<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Container;

use Nikolai\Php\Infrastructure\Service\FormBuilderInterface;
use Nikolai\Php\Infrastructure\Service\FormBuilderService;
use Nikolai\Php\Infrastructure\Service\PublishMessageInterface;
use Nikolai\Php\Infrastructure\Service\PublishMessageService;
use Nikolai\Php\Infrastructure\Service\ConsumeMessageInterface;
use Nikolai\Php\Infrastructure\Service\ConsumeMessageService;
use Nikolai\Php\Infrastructure\MessageHandler\MessageHandlerInterface;
use Nikolai\Php\Infrastructure\MessageHandler\ReportFormMessageHandler;
use Nikolai\Php\Infrastructure\Service\NotificationSenderInterface;
use Nikolai\Php\Infrastructure\Service\EmailNotificationSenderService;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;
use Twig\Environment;
use DI;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\FactoryRuntimeLoader;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ContainerBuilder implements ContainerBuilderInterface
{
    public function __construct(private Request $request, private array $configuration) {}

    public function build(): Container
    {
        $builder = new \DI\ContainerBuilder();

        $builder->addDefinitions([
            Environment::class => function ($container) {
                $defaultFormTheme = 'form_div_layout.html.twig';
                $templatesDirectory = dirname(__DIR__, 3) . '/templates';
                $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
                $vendorTwigBridgeDirectory = dirname($appVariableReflection->getFileName());
                $viewsDirectory = realpath(__DIR__.'/../views');

                $twig = new Environment(new FilesystemLoader([
                    $viewsDirectory,
                    $vendorTwigBridgeDirectory.'/Resources/views/Form',
                    $templatesDirectory
                ]));
                $formEngine = new TwigRendererEngine([$defaultFormTheme], $twig);
                $twig->addRuntimeLoader(new FactoryRuntimeLoader([
                    FormRenderer::class => function () use ($formEngine) {
                        return new FormRenderer($formEngine);
                    },
                ]));

                $translator = new Translator('en');
                $twig->addExtension(new FormExtension());
                $twig->addExtension(new TranslationExtension($translator));

                return $twig;
            },
            FormBuilderInterface::class =>
                DI\autowire(FormBuilderService::class),
            AMQPStreamConnection::class => function () {
                $host = $this->request->server->get('RABBITMQ_HOST');
                $port = $this->request->server->get('RABBITMQ_PORT');
                $user = $this->request->server->get('RABBITMQ_USER');
                $password = $this->request->server->get('RABBITMQ_PASSWORD');
                $vhost = $this->request->server->get('RABBITMQ_VHOST');

                return new AMQPStreamConnection($host, $port, $user, $password, $vhost);
            },
            PublishMessageInterface::class =>
                DI\autowire(PublishMessageService::class)
                    ->constructorParameter('queue', $this->request->server->get('RABBITMQ_QUEUE'))
                    ->constructorParameter('exchange', $this->request->server->get('RABBITMQ_EXCHANGE')),
            ConsumeMessageInterface::class =>
                DI\autowire(ConsumeMessageService::class)
                    ->constructorParameter('queue', $this->request->server->get('RABBITMQ_QUEUE'))
                    ->constructorParameter('exchange', $this->request->server->get('RABBITMQ_EXCHANGE')),
            MessageHandlerInterface::class =>
                DI\autowire(ReportFormMessageHandler::class),
            PHPMailer::class => function () {
                $mailer = new PHPMailer(true);
                $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
                $mailer->isSMTP();
                $mailer->Host       = $this->request->server->get('EMAIL_HOST');
                $mailer->SMTPAuth   = true;
                $mailer->Username   = $this->request->server->get('EMAIL_USER');
                $mailer->Password   = $this->request->server->get('EMAIL_PASSWORD');
                $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mailer->Port       = $this->request->server->get('EMAIL_PORT');

                $mailer->setFrom('from@example.com', 'Mailer');

                return $mailer;
            },
            NotificationSenderInterface::class =>
                DI\autowire(EmailNotificationSenderService::class),
        ]);

        $container = $builder->build();

        return new Container($container);
    }
}
import {bracketsHandler, emailsHandler, changeApiHandler, generatorHandler} from './events.js';

document.querySelector('button')
  .addEventListener('click', generatorHandler);

document.querySelector('input[name="emails"]')
  .addEventListener('click', emailsHandler);

document.querySelector('input[name="brackets"]')
  .addEventListener('click', bracketsHandler);

[...document.querySelectorAll('input[name="apiChanger"]')]
  .forEach((radio)=>{
    radio.addEventListener('click', changeApiHandler);
  })

import React from 'react';
import {useGoogleLogin} from '@react-oauth/google';
import {useLoginByCodeMutation} from '../../redux/services/googleAuthApi';
import {setCredentials} from '../../redux/slices/authSlice';
import {useAppDispatch} from '../../redux/hooks';
import {useNavigate} from 'react-router-dom';
import {toast} from 'react-toastify';

type Props = {};
const GoogleSignInButton: React.FC<Props> = ({}) => {
    const dispatch = useAppDispatch();
    const navigate = useNavigate();
    const [loginByCode] = useLoginByCodeMutation();

    const login = useGoogleLogin({
        onSuccess: async codeResponse => {
            const scopesOk = allScopesGranted(codeResponse.scope);

            if (!scopesOk) {
                alert('Необходимо выбрать все разрешения!');
                return;
            }
            await loginByCode(codeResponse)
                .unwrap()
                .then(user => {
                    dispatch(setCredentials(user));
                    toast.success('Добро пожаловать!');
                    navigate('/');
                })
                .catch(() => {
                    toast.error(
                        'Ошибка. Попробуйте еще раз или обратитесь к администратору.',
                    );
                });
        },
        flow: 'auth-code',
        scope: 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
    });

    const allScopesGranted = (grantedScopes: string) => {
        let isOk = true;
        const needScope = [
            'email',
            'profile',
            'openid',
            'https://www.googleapis.com/auth/userinfo.profile',
            'https://www.googleapis.com/auth/userinfo.email',
        ];
        needScope.map(search => {
            if (!grantedScopes.includes(search)) isOk = false;
        });
        return isOk;
    };

    return (
        <button
            className="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3"
            onClick={login}>
            Войти с помощью Google
        </button>
    );
};

export default GoogleSignInButton;

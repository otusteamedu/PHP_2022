import React from 'react';
import {useGoogleLogin} from '@react-oauth/google';
import {Button} from '@mui/material';
import {
    useGetSpreadsheetEmailQuery,
    useConnectSpreadsheetsAccountMutation,
} from '../redux/services/googleAuthApi';
import ActivityIndicator from '../components/ActivityIndicator';

function GoogleSpreadsheets() {
    const [connectSpreadsheetsAccountMutation] =
        useConnectSpreadsheetsAccountMutation();
    const {
        data: email,
        isLoading,
        isFetching,
    } = useGetSpreadsheetEmailQuery('');

    const connect = useGoogleLogin({
        onSuccess: codeResponse => {
            console.log(codeResponse);
            const scopesOk = allScopesGranted(codeResponse.scope);

            if (!scopesOk) alert('Необходимо выбрать все разрешения!');
            else connectSpreadsheetsAccountMutation(codeResponse);
        },
        flow: 'auth-code',
        scope: 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/spreadsheets https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/drive.readonly',
    });

    const allScopesGranted = (grantedScopes: string) => {
        let isOk = true;
        const needScope = [
            'email',
            'profile',
            'https://www.googleapis.com/auth/spreadsheets',
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive.readonly',
            'openid',
            'https://www.googleapis.com/auth/userinfo.profile',
            'https://www.googleapis.com/auth/userinfo.email',
        ];
        needScope.map(search => {
            if (!grantedScopes.includes(search)) isOk = false;
        });
        return isOk;
    };

    if (isLoading || isFetching) return <ActivityIndicator />;
    return (
        <div className="text-sm mb-4 p-4">
            <div className="mb-4">
                <h1 className="text-2xl md:text-3xl text-gray-800 font-bold">
                    Google таблицы
                </h1>
            </div>
            <div>
                Лиды по всем вашим квизам будут выгружаться в таблицы на Google
                Drive подключенного аккаунта.
            </div>
            {email === false
                ? 'Аккаунт не подключен. Выгрузка статистики производиться не будет.'
                : 'Подключен аккаунт ' + email + '.'}
            <div>
                <button
                    onClick={connect}
                    className="btn bg-indigo-500 hover:bg-indigo-600 text-white mt-2">
                    Подключить {email && 'другой'} аккаунт Google
                </button>
            </div>
        </div>
    );
}

export default GoogleSpreadsheets;

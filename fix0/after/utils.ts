export const allScopesGranted = (
    grantedScopes: string,
    needScopes: string[],
): boolean => {
    let isOk = true;
    needScopes.map(search => {
        if (!grantedScopes.includes(search)) isOk = false;
    });
    return isOk;
};

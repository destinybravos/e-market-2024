let storeAuthUser = (user, token = null) => {
    if (token !== null) {
        localStorage.setItem('auth_token', token);
        localStorage.setItem('active_user', JSON.stringify(user));
        localStorage.setItem('is_logded_in', true);
    }
}

let getUserObject = () => {
    let activeUser = localStorage.getItem('active_user');

    if (activeUser == null || activeUser == undefined || activeUser == '') {
        return null;
    }

    let user = JSON.parse(activeUser);
    
    return user
}

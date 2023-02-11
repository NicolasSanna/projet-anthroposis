class PasswordManager
{
    constructor()
    {
        this.button = document.getElementById('showPassword');
        this.inputPassword = document.getElementById('inputPassword');

        this.button.addEventListener('click', this.onClickShowPassord.bind(this));
    }

    onClickShowPassord()
    {
        this.inputPassword.type = this.inputPassword.type === 'password' ? 'text' : 'password';
        this.button.value = this.button.value === 'Voir' ? 'Cacher' : 'Voir';
    }
}

const passManag = new PasswordManager();
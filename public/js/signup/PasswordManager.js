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
        this.inputPassword.type = this.inputPassword.type === 'password' ? this.inputPassword.type = 'text' : 'password';
        this.button.value = this.button.value === 'Voir' ? this.button.value = 'Cacher' : 'Voir';
    }
}

const passManag = new PasswordManager();
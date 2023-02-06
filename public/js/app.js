class App
{
    constructor()
    {       
        this.burger = document.getElementById('burger');
        this.cross = document.getElementById('cross');
        this.menu = document.querySelector('.Header-Navbar-menu');

        this.installEventHandlers(); 
    }

    installEventHandlers()
    {
        this.burger.addEventListener('click', this.onClickBurger.bind(this));
        this.cross.addEventListener('click', this.onClickCross.bind(this));
    }

    onClickBurger()
    {
        this.menu.classList.remove('inactive');
        this.menu.classList.add('active');
    }

    onClickCross()
    {
        this.menu.classList.remove('active');
        this.menu.classList.add('inactive');
    }
}

const app = new App();
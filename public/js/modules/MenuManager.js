export default class MenuManager
{
    constructor()
    {       
        this.burger = document.getElementById('burger');
        this.cross = document.getElementById('cross');
        this.menu = document.querySelector('.Header-Navbar-menu');
        this.window = window;

        this.installEventHandlers(); 
    }

    installEventHandlers()
    {
        this.burger.addEventListener('click', this.onClickBurger.bind(this));
        this.cross.addEventListener('click', this.onClickCross.bind(this));
        this.window.addEventListener('resize', this.onResizeWindowWidth.bind(this));
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

    onResizeWindowWidth()
    {
        this.pageWidth  = document.documentElement.scrollWidth;

        if(this.pageWidth >= 1200)
        {
            this.menu.classList.remove('active');
            this.menu.classList.remove('inactive');
        }
    }
}
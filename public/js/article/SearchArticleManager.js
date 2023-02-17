class SearchArticleManager
{
    constructor()
    {
        this.form = document.querySelector('.Form');
        this.aside = document.querySelector('.aside');

        this.form.addEventListener('submit', this.onSubmitForm.bind(this))
    }

    async onSubmitForm(e)
    {
        e.preventDefault();

        const formData = new FormData(this.form);

        const search = formData.get('search');

        this.aside.innerHTML = '';

        if(search.trim().length === 0)
        {
            const p = document.createElement('p');
            p.classList.add('Message');
            p.classList.add('Error-message');
            p.textContent = 'Le champ de recherche est vide';
            this.aside.appendChild(p);
        }
        else
        {

            const url = this.form.action;
            const options = {

                method: 'post',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }

            const response = await fetch(url, options)
            const results = await response.json();

            console.log(results);
        }
    }
}

const srchArtManag = new SearchArticleManager();
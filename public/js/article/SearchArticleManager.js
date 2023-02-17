class SearchArticleManager
{
    constructor()
    {
        this.form = document.querySelector('.Form');
        this.aside = document.querySelector('.aside');
        this.page = document.querySelector('.Page');
        this.divList = document.querySelector('.Page-articles');

        this.p = document.createElement('p');
        this.p.classList.add('Message');
        this.p.classList.add('Error-message');

        this.form.addEventListener('submit', this.onSubmitForm.bind(this))
    }

    async onSubmitForm(e)
    {
        e.preventDefault();

        const formData = new FormData(this.form);
        const search = formData.get('search');

        this.aside.innerHTML = '';
        this.divList.innerHTML = '';

        if(search.trim().length === 0)
        {
            this.p.textContent = 'Le champ de recherche est vide';
            this.aside.appendChild(this.p);
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

            const response = await fetch(url, options);
            const results = await response.json();

            if(results.length === 0)
            {
                this.p.textContent = 'Aucun article ne correspond à votre recherche';
                this.aside.appendChild(this.p);
            }
            else
            {
                for(const result of results)
                {
                    this.divList.innerHTML = this.divList.innerHTML + 
                    `
                        <div class="Page-articles-article">
                            <p class="Page-articles-article-author">${result.pseudo}</p>
                            <p class="Page-articles-article-date">${result.date_fr}</p>
                            <h4 class="Page-articles-article-title"><a  class="Page-articles-article-link" href="${result.articleUrl}">${result.title}</a></h4>
                            <p class="Page-articles-article-description">${result.description}</p>
                            <p class="Page-articles-article-category"><a class="Page-articles-article-category-link" href="${result.categoryUrl}">${result.category_name}</a></p>
                            <hr>
                        </div>
                    
                    `
                }
            }
        }
    }
}

const srchArtManag = new SearchArticleManager();
class DeleteArticleManager
{
    constructor()
    {
        this.articles = document.querySelectorAll('.Admin-delete')

        for(const articleToDelete of this.articles)
        {
            articleToDelete.addEventListener('click', this.onClickDelete.bind(articleToDelete))
        }
    }

    async onClickDelete(e)
    {
        e.preventDefault();

        const confirmation = window.confirm('Êtes-vous sûr de vouloir supprimer cet article ? ');

        if (confirmation === true)
        {
            const url = e.target.href
    
            const options = 
            {
                headers:
                {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }

            const response = await fetch(url, options);
            const articleSlug = await response.json();

            const tr = document.getElementById(`article-${articleSlug}`)
            tr.remove();

            alert('Article supprimé');
        }
    }
}

const delArtManag = new DeleteArticleManager();
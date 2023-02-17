class DeleteCategoryManager
{
    constructor()
    {
        this.delWithArtBtns = document.querySelectorAll('.Admin-delete-with-articles')
        this.delWithoutArtBtns = document.querySelectorAll('.Admin-delete-without-articles')

        for (const delWithArtBtn of this.delWithArtBtns)
        {
            delWithArtBtn.addEventListener('click', this.onClickDeleteWithArticles.bind(delWithArtBtn))
        }

        for (const delWithoutArtBtn of this.delWithoutArtBtns)
        {
            delWithoutArtBtn.addEventListener('click', this.onClickDeleteWithoutArticles.bind(delWithoutArtBtn))
        }
    }

    async onClickDeleteWithArticles(e)
    {
        e.preventDefault();
        
        const confirmation = window.confirm('Êtes-vous sûr de vouloir supprimer cette catégorie et ses articles associés ? ');

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
            const categoryId = await response.json();

            const tr = document.getElementById(`category-${categoryId}`)
            tr.remove();

            alert('La catégorie et ses articles ont supprimés');
        }
    }

    async onClickDeleteWithoutArticles(e)
    {
        e.preventDefault();
        
        const confirmation = window.confirm('Êtes-vous sûr de vouloir supprimer cette catégorie en conservant ses articles associés ? ');

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
            const categoryId = await response.json();

            const tr = document.getElementById(`category-${categoryId}`)
            tr.remove();

            alert('La catégorie a été supprimée');
        }
    }
}

const delCatManag = new DeleteCategoryManager();
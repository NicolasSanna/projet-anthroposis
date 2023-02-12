class UploadImageManager
{
    constructor()
    {
        this.inputImage = document.getElementById('inputImage');
        this.previewImg = document.getElementById('previewImg'); 
        this.form = document.getElementById('Form');

        this.validMimes = ['image/png', 'image/jpeg', 'image/jpg', 'image/img']

        this.installEventHandlers();
    }

    installEventHandlers()
    {
        this.inputImage.addEventListener('change', this.onChangeImage.bind(this));
        this.form.addEventListener('submit', this.onSubmitForm.bind(this));
    }

    onChangeImage(e)
    {
        let src = URL.createObjectURL(e.target.files[0]);

        this.previewImg.src = src;
    }

    onSubmitForm(e)
    {
        if(this.inputImage.files && this.inputImage.files.length == 1)
        {
            const fileInfoMime = this.inputImage.files[0].type

            if(this.validMimes.includes(fileInfoMime) == false)
            {
                alert('L\'extension du fichier n\'est pas bonne.');
                e.preventDefault();
            }   

            if (inputFile.files[0].size > 2000000)
            {
                alert('Le fichier image est trop volumineux (au-delà de 2Mo)');
                e.preventDefault();
            }
        }
    }
}

const uploadImgManag = new UploadImageManager();
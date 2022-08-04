const input = document.querySelector('.image-selector input[type="file"]') as HTMLInputElement;
const label = document.querySelector('.image-selector label') as HTMLLabelElement;
const originalLabelInnerHTML = label.innerHTML;
const previewImg = document.querySelector('.image-selector .preview img') as HTMLImageElement;
const previewWrapper = document.querySelector('.image-selector .preview') as HTMLDivElement;
const deleteButton = document.querySelector('.image-selector button') as HTMLButtonElement;

input.addEventListener('change', (event: Event) => {
    const inputTarget = event.target as HTMLInputElement;
    const file = inputTarget.files?.item(0);
    
    if (file) {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.addEventListener('load', () => {
            previewImg.src = reader.result as string;
            previewWrapper.classList.remove('hidden');
        });
        label.innerHTML = file.name;
    }
});

deleteButton.addEventListener('click', () => {
    input.value = '';
    previewImg.src = '';
    previewWrapper.classList.remove('hidden')
    label.innerHTML = originalLabelInnerHTML;
})
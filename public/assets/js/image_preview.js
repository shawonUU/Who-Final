function previewImage(e, selectedFiles, imagesArray) {
    const elemContainer = document.createElement('div');
    elemContainer.setAttribute('class', 'item-images');
    for (let i = 0; i < selectedFiles.length; i++) {
      imagesArray.push(selectedFiles[i]);
      const imageContainer = document.createElement('div');
      const elem = document.createElement('img');
      elem.setAttribute('src', URL.createObjectURL(selectedFiles[i]));
      elem.setAttribute('class', 'item-photo__preview')
      const removeButton = document.createElement('button');
      removeButton.setAttribute('type', 'button');
      removeButton.classList.add('delete');
      removeButton.dataset.filename = selectedFiles[i].name,
      removeButton.innerHTML = '<span>&times;</span>'
      imageContainer.appendChild(elem);
      imageContainer.appendChild(removeButton);
      elemContainer.appendChild(imageContainer);
    }
    return elemContainer;
  }
  let item_images = [];
  document.getElementById('photo-upload').addEventListener('change', (e) => {
    let selectedFiles = e.target.files;
    $('#photo-upload__preview').empty();
    const photoPreviewContainer = document.querySelector('#photo-upload__preview');
    const elemContainer = previewImage(e, selectedFiles, item_images);
    photoPreviewContainer.appendChild(elemContainer);
  });
  
  document.getElementById('photo-upload__preview').addEventListener('click', (e) => {
    console.log('click');
    const tgt = e.target.closest('button');
    if (tgt.classList.contains('delete')) {
      tgt.closest('div').remove();
      const fileName = tgt.dataset.filename
      item_images = item_images.filter(img => img.name != fileName)
      $("#photo-upload").val(null);
    }
  })
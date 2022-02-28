document.addEventListener('DOMContentLoaded',(e)=>{
    let addBtn = document.querySelectorAll('.add_item_link');
    addBtn.forEach(btn => btn.addEventListener("click", addFormToCollection));
})

const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
    const item = document.createElement('div');
    // item.attr('class','row list-group-item');
    item.className = 'list-group-item border-dark';
    item.innerHTML = collectionHolder
      .dataset
      .prototype
      .replace(
        /__name__/g,
        collectionHolder.dataset.index
      );
    collectionHolder.appendChild(item);
    collectionHolder.dataset.index++;
};

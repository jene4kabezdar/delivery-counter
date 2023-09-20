const countBtn = document.getElementById('count');

const DELIVERY_TYPES = ['Быстрая', 'Медленная'];

const deleteAllElems = (selector) => {
    const elems = document.querySelectorAll(selector);
    elems.forEach(e => {
        e.remove();
    });
}

countBtn.addEventListener('click', (event) => {
    event.preventDefault();
   const source = document.getElementById('source').value;
   const target = document.getElementById('target').value;
   let weight = parseFloat(document.getElementById('weight').value);
   if (!weight) {
       weight = 0
   }
   let id = parseInt(document.getElementById('type').value);
    if (!id) {
        id = 0
    }

    fetch('/getById?' + new URLSearchParams({
        source,
        target,
        weight,
        id
    }))
        .then(res => res.json())
        .then(data => {
            const form = document.getElementById('form');
            const selectors = ['.price', '.date', '.title', '.error'];

            selectors.forEach(selector => {
                deleteAllElems(selector);
            })

            if (data?.error) {
                form.insertAdjacentHTML('beforeend', `<div class="form-item error">Ошибка - ${data.error}</div>`);
            } else {
                if (!Array.isArray(data)) {
                    form.insertAdjacentHTML('beforeend', `<div class="form-item price">Цена - ${data.price}</div>`);
                    form.insertAdjacentHTML('beforeend', `<div class="form-item date">Дата - ${data.date}</div>`);
                } else {
                    data.forEach((e, i) => {
                        form.insertAdjacentHTML('beforeend', `<div class="form-item title">${DELIVERY_TYPES[i]}</div>`);
                        form.insertAdjacentHTML('beforeend', `<div class="form-item price">Цена - ${e.price}</div>`);
                        form.insertAdjacentHTML('beforeend', `<div class="form-item date">Дата - ${e.date}</div>`);
                    })
                }
            }
        });
});
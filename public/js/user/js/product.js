let products = [
    {
        name: 'Keychron-C2',
        image1: 'images/Keychron-C2_v4.jpg',
        image2: 'images/Keychron-C2_v5.jpg',
        old_price: '80',
        curr_price: '70',
        inCart: 0
    },
    {
        name: 'Keychron-K1',
        image1: 'images/Keychron-K1_v4.jpg',
        image2: 'images/Keychron-K1_v5.jpg',
        old_price: '80',
        curr_price: '70',
        inCart: 0
    },
    {
        name: 'Keychron-K2',
        image1: 'images/Keychron-K2_v4.jpg',
        image2: 'images/Keychron-K2_v5.jpg',
        old_price: '80',
        curr_price: '70',
        inCart: 0
    },
    {
        name: 'Keychron-K3',
        image1: '/images/Keychron-K3_v4.jpg',
        image2: '/images/Keychron-K3_v5.jpg',
        old_price: '80',
        curr_price: '70',
        inCart: 0
    },
    {
        name: 'Keychron-K4',
        image1: 'images/Keychron-K4_v4.jpg',
        image2: 'images/Keychron-K4_v5.jpg',
        old_price: '80',
        curr_price: '70',
        inCart: 0
    },
    {
        name: 'Keychron-K6',
        image1: 'images/Keychron-K6_v4.jpg',
        image2: 'images/Keychron-K6_v5.jpg',
        old_price: '80',
        curr_price: '70',
        inCart: 0
    },
    {
        name: 'Keychron-K8',
        image1: 'images/Keychron-K8_v4.jpg',
        image2: 'images/Keychron-K8_v5.jpg',
        old_price: '80',
        curr_price: '70',
        inCart: 0
    },
]

let product_list = document.querySelector('#products')

renderProducts = (products) => {
    products.forEach(e => {
        let prod = `
            <div class="col-4 col-md-6 col-sm-12">
                <div class="product-card">
                    <div class="product-card-img">
                        <img src="${e.image1}" alt="">
                        <img src="${e.image2}" alt="">
                    </div>
                    <div class="product-card-info">
                        <div class="product-btn">
                            <a href="product-detail.html" class="btn-flat btn-hover btn-shop-now">shop now</a>
                            <a class="btn-flat btn-hover btn-cart-add add-cart" id="add-to-cart">
                                <i class='bx bxs-cart-add '></i>
                            </a>
                            <button class="btn-flat btn-hover btn-cart-add">
                                <i class='bx bxs-heart'></i>
                            </button>
                        </div>
                        <div class="product-card-name">
                            ${e.name}
                        </div>
                        <div class="product-card-price">
                            <span><del>$${e.old_price}</del></span>
                            <span class="curr-price">$${e.curr_price}</span>
                        </div>
                    </div>
                </div>
            </div>
        `
        product_list.insertAdjacentHTML("beforeend", prod)
        
    })
}

renderProducts(products)
renderProducts(products)

let filter_col = document.querySelector('#filter-col')

document.querySelector('#filter-toggle').addEventListener('click', () => filter_col.classList.toggle('active'))

document.querySelector('#filter-close').addEventListener('click', () => filter_col.classList.toggle('active'))



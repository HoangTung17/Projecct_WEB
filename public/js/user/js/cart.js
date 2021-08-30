let carts = document.querySelectorAll('#add-to-cart');

for (let i = 0; i < carts.length; i++) {
  carts[i].addEventListener('click', () => {
    cartNumbers(products[i]);
    totalCost(products[i]);
  });
}

function onLoadCartNumbers() {
  let productNumbers = localStorage.getItem('cartNumbers');

  if (productNumbers) {
    document.querySelector('.cart span').textContent = productNumbers;
  }
}

function cartNumbers(product) {
  let productNumbers = localStorage.getItem('cartNumbers');

  productNumbers = parseInt(productNumbers);

  if (productNumbers) {
    localStorage.setItem('cartNumbers', productNumbers + 1);
    document.querySelector('.cart span').textContent = productNumbers + 1;
  } else {
    localStorage.setItem('cartNumbers', 1);
    document.querySelector('.cart span').textContent = 1;
  }

  setItems(product);
}

function setItems(product) {
  let cartItems = localStorage.getItem('productsInCart');
  cartItems = JSON.parse(cartItems);

  if (cartItems != null) {

    if(cartItems[product.name] == undefined) {
      cartItems = {
        ...cartItems,
        [product.name]: product
      }
    }
    cartItems[product.name].inCart += 1;
  } else {
    product.inCart = 1;
    cartItems = {
      [product.name]: product
    }
  }

  localStorage.setItem('productsInCart', JSON.stringify(cartItems));
}

function totalCost(product) {
  // console.log('The product price is', product.curr_price);

  let cartCost = localStorage.getItem('totalCost');

  console.log('My CartCost is', cartCost);
  console.log(typeof cartCost);

  if (cartCost != null) {
    cartCost = parseInt(cartCost);
    product.curr_price = parseInt(product.curr_price);
    localStorage.setItem('totalCost', cartCost + product.curr_price);
  } else {
    localStorage.setItem('totalCost', product.curr_price);
  }
}

function displayCart() {
    let cartItems = localStorage.getItem('productsInCart');
    cartItems = JSON.parse(cartItems);
    let productContainer = document.querySelector('.products');
    let cartCost = localStorage.getItem('totalCost');

  console.log(cartItems);
  if (cartItems && productContainer) {
    productContainer.innerHTML = '';
    Object.values(cartItems).map((item) => {
      productContainer.innerHTML += `
        <div class='product'>
            <i class='bx bx-trash'></i>
            <img class='img-cart' src='${item.image1}' alt=''>
            <span>${item.name}</span>
        </div>
        <div class='price'>
        $${item.curr_price} 
        </div>
        <div class='quantity'> 
            <i class='bx bx-down-arrow'></i>
            <span>${item.inCart}</span>
            <i class='bx bx-up-arrow' ></i>
        </div>
        <div class='total'>
        $${item.inCart * item.curr_price}
        </div>
        
      `;
    });
    productContainer.innerHTML += `
        <div class='basketTotalContainer'>
        <h4 class=''basketTitleTotal>
            Basket Total
        </h4>
        <h4 class='basketTotal'>
            $${cartCost}
        </h4>
        </div>
    `;
  }
}

onLoadCartNumbers();
displayCart();


    let navbar = document.querySelector('.navbar');
    document.querySelector('#menu-btn').onclick = () => {
      console.log('Menu button clicked');
      navbar.classList.toggle('active');
      searchForm.classList.remove('active');
      cartItem.classList.remove('active');
      
    }
    document.getElementById('signup-btn').addEventListener('click', function() {
        document.querySelector('.signup-form-container').classList.toggle('active');
    });
   


let searchForm = document.querySelector('.search-form');
document.querySelector('#search-btn').onclick = () => {
    console.log('search button clicked');

    searchForm.classList.toggle('active');
    navbar.classList.remove('active');
    cartItem.classList.remove('active');
   
}


let cartItem = document.querySelector('.cart-items-container');
    document.querySelector('#cart-btn').onclick = () => {
        console.log('cart button clicked');

    cartItem.classList.toggle('active');
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
    }



window.onscroll = () =>{
    navbar.classList.remove('active');
    searchForm.classList.remove('active');
    cartItem.classList.remove('active');

}



document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        console.log('Adding product to cart:', productId);

        fetch('addtocart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ productId: productId })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log('Product added to cart');
                updateCartUI(data.cartItems);
            } else {
                console.log('Failed to add product to cart:', data.message);
                alert('Failed to add product to cart: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while adding the product to cart');
        });
    });
});

function updateCartUI(cartItems) {
    let cartContainer = document.querySelector('.cart-items-container');
    cartContainer.innerHTML = ''; // Clear current items

    cartItems.forEach(item => {
        let cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');

        cartItem.innerHTML = `
            <div class="image">
                <img src="image/${item.image}" alt="${item.prodName}">
            </div>
            <div class="content">
                <h3>${item.prodName}</h3>
                <div class="price">R${item.price}</div>
                <div class="quantity">Quantity: ${item.quantity}</div>
            </div>
        `;

        cartContainer.appendChild(cartItem);
    });
}



$(document).ready(function() {

    $('.add-to-cart-btn').on('click', function() {
        const mangaId = $(this).data('manga-id');
        
        $.ajax({
            url: 'php/phpLogic/ajaxcart.php',
            type: 'POST',
            data: {
                action: 'add',
                manga_id: mangaId
            },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    $('#cart-count').text(response.cart_count);
                    alert('Item added to cart!');
                } else {
                    alert(response.message);
                }
            }
        });
    });

    $('.quantity-input').on('change', function() {
        const mangaId = $(this).closest('.cart-item').data('manga-id');
        const quantity = $(this).val();

        $.ajax({
            url: 'php/phpLogic/ajaxcart.php',
            type: 'POST',
            data: {
                action: 'update',
                manga_id: mangaId,
                quantity: quantity
            },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                
                    location.reload();
                }
            }
        });
    });

    $('.remove-btn').on('click', function() {
        const mangaId = $(this).closest('.cart-item').data('manga-id');

        if (confirm('Are you sure you want to remove this item?')) {
            $.ajax({
                url: 'php/phpLogic/ajaxcart.php',
                type: 'POST',
                data: {
                    action: 'remove',
                    manga_id: mangaId
                },
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                      
                        $(`.cart-item[data-manga-id=${mangaId}]`).remove();
                     
                        $('#cart-count').text(response.cart_count);
                         location.reload();
                    }
                }
            });
        }
    });
});

<script>

$('.owl-carousel').each(function(){
    var carousel = $(this);
    carousel.owlCarousel({
        loop:false,
        margin:10,
        nav:true,
        navText: [
        '<i class="fa fa-arrow-left"></i>',
        '<i class="fa fa-arrow-right"></i>'
        ],
        responsive:{
            0:{
                    items: carousel.data('xs')
            },
            768:{
                items: carousel.data('sm')
            },
            992:{
                items: carousel.data('md')
            },
            1200:{
                items: carousel.data('lg')
            }
        }
    })
})

</script>
( function( $ ) {

	/**
	 * Testimonial Carousel
	 *
	 */
	var WidgetTestimonialCarousel = function( $scope, $ ) {
        const element = $scope[0].querySelector( '.ce-testimonial-carousel' );
    
        const responsiveOptions = {
            768:{
                items: parseInt( element.dataset.columns ) == 1 ? 1 : 2,
            },
            1024:{
                items: parseInt( element.dataset.columns ),
                center: parseInt( element.dataset.center ),
                startIndex: parseInt( element.dataset.startIndex ),
            }
        };

        if( element.dataset.edgePadding && element.dataset.edgePadding != 0 )
            responsiveOptions[1024]['edgePadding'] = parseInt( element.dataset.edgePadding );
   

        let options = {
            container: element,
            items: 1,
            slideBy: parseInt( element.dataset.slideBy ),
            autoplay: parseInt( element.dataset.autoplay ),
            mouseDrag: parseInt( element.dataset.mouseDrag ),
            loop: parseInt( element.dataset.loop ),
            responsive: responsiveOptions,
            mode: element.dataset.mode,
            gutter: parseInt( element.dataset.gutter ),
            controls: false,
            nav: false,
            onInit: function( info ){
                if( parseInt( element.dataset.center ) ){
                    info.slideItems[1].classList.add( "centered" );
                }
                if( parseInt( element.dataset.edgePaddingSide ) )
                    info.container.style.transform = 'translate3D(0,0,0)';
                    
                window.ce_waypoint_animation( $( info.container ).find( '.tns-slide-active' ), true );

                
            }
        };

        if( element.classList.contains( 'ce-testimonial-style-tista' ) )
            options['startIndex'] = 1;

        if( element.classList.contains( 'ce-testimonial-style-modern' ) )
            element.parentNode.parentNode.setAttribute('data-style', 'modern');

        var slider = tns( options );

        slider.events.on("transitionEnd", function(info) {
            if( parseInt( element.dataset.center ) ){
                info.slideItems[info.indexCached].classList.remove(
                "centered"
                );
            
                info.slideItems[info.index].classList.add(
                "centered"
                );   
            }
            
            window.ce_waypoint_animation( $( info.container ).find( '.tns-slide-active' ), true );
        });
        
        if( parseInt( element.dataset.carouselControls ) ){
            $(element).closest( '.elementor-widget-ce-testimonial-carousel' );
            var parentSel = $(element).closest( '.elementor-widget-ce-testimonial-carousel' )[0];
            parentSel.querySelectorAll( '.ce-testimonial-carousel-controls .ce-prev' ).forEach( (el) => el.onclick = function(e){
                e.preventDefault();
                slider.goTo('prev');
            });
            parentSel.querySelectorAll( '.ce-testimonial-carousel-controls .ce-next' ).forEach( (el) => el.onclick = function(e){
                e.preventDefault();
                slider.goTo('next');
            });
        }

        

        if( element.classList.contains( 'ce-testimonial-style-tista' ) ){
            var newNav = document.createElement( "DIV" );
            newNav.classList.add('ce-testimonial-style-tista-nav');
            newNav.classList.add( 'ce-testimonial-nav-container' );
            NodeList.prototype.indexOf = Array.prototype.indexOf;
            for (let item of element.querySelectorAll( '.ce-testimonial-item' )) {
                var child = document.createElement("DIV");
                child.classList.add('nav-item');
                
                child.innerHTML = item.dataset.dot;
                child.onclick = function(){
                    this.parentNode.querySelectorAll( '.nav-item' ).forEach(function(i){
                        i.classList.remove('active');
                    });
                    this.classList.add('active');
                    slider.goTo( newNav.querySelectorAll('.nav-item').indexOf(this) );
                };
                
                newNav.appendChild( child );
            }

            element.parentNode.appendChild( newNav );
            newNav.children[1].classList.add('active');
        }
    };

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/ce-testimonial-carousel.default', WidgetTestimonialCarousel );

	});

} )( jQuery );
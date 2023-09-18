    // Ignore this class, it just looks prettier to call functions from a class vs make seperate ones
    class Components {

        // ===================================================================================================================================================
        // == Components Setup for TailwindCSS ==
        // == >> Logan Ferkey (4/16/23)
        // !! Change options below as necessary or this will not work!!
        // ===================================================================================================================================================
        // << == Mobile Navbar Options == >>
        // The id of your mobile navbar
        static mobileNav = '#mobile-nav';
        // The id of your navbar collapse button (hamburger)
        static navButton = '#navbar-collapse';
        // =================================
        // == The SVG paths for your navbar button
        // When the navbar is closed, this should be a 3 bar svg (hamburger)
        static bars = 'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5';
        // When the navbar is opened, should be an X for closing
        static X = 'M6 18L18 6M6 6l12 12';
        // << == Dropdown Menu Options == >>
        // The class of your div that holds/is the dropdown menu
        static dropdownContainers = '.dropdown-toggle';
        // The classname of your div that is the dropdown menu, inside dropdown-toggle
        static dropdownMenu = '.dropdown-menu';
        // =================================
        // << == Tooltip Options ======== >>
        // =================================

        static SetupMobileNavbar() {
            let mN = $(Components.mobileNav);
            let nB = $(Components.navButton);
            let icon = nB.children('path');
            nB.on('click', function() {
                if (icon.attr('d') == Components.bars) {
                    icon.attr('d', Components.X);
                    mN.removeClass('left-[-100%]').addClass('left-0');
                } else {
                    icon.attr('d', Components.bars);
                    mN.removeClass('left-0').addClass('left-[-100%]');
                }
            });
            $(window).on('resize', function() {
                if ($(window).width() > 768) {
                    icon.attr('d', Components.bars);
                    mN.removeClass('left-0').addClass('left-[-100%]');
                }
            });
        }

        static CloseMobileNavbar() {
            let mN = $(Components.mobileNav);
            let nB = $(Components.navButton);
            let icon = nB.children('path');
            icon.attr('d', Components.bars);
            mN.removeClass('left-0').addClass('left-[-100%]');
        }

        static SetupDropdowns() {
            let dropdowns = $(Components.dropdownContainers);
            dropdowns.each(function() {
                $(this).on('click', function() {
                    let menu = $(this).children(Components.dropdownMenu);
                    if (menu)
                        menu.hasClass('hidden') ? menu.removeClass('hidden') : menu.addClass('hidden');
                });
            });
            $(document).on('click', function (e) {
                // Grab the list of menus
                $(Components.dropdownMenu).each(function () {
                    let menu = $(this);
                    let toggle = menu.parent()[0];
                    let itemParent = $(e.target).parent()[0];
                    if (itemParent != toggle) {
                        if (!menu.hasClass('hidden'))
                            menu.addClass('hidden');
                    }
                });
            });
        }

        static SetupModals(modalClass) {
            $('[data-modal-target]').each(function(index, button) {
                let modalButton = $(this);
                let id = modalButton.data('modal-target');
                let modal = $("#"+id);
                if (modal.length) {
                    modalButton.on('click', function() {
                        modal[0].showModal();
                    });
                    modal.find('.close').each(function(index, ele) {
                        $(this).on('click', function() {
                            modal[0].close();
                        });
                    });
                }
            });
          }

        static SetupTooltips() {
            // Tooltips
        }
    }

    $(document).ready(function () {
        // Look through the DOM and wire up all components if need be
        Components.SetupMobileNavbar();
        Components.SetupDropdowns();
        Components.SetupModals();
        Components.SetupTooltips();
    });
    




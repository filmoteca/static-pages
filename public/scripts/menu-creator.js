/* globals $ */

/**
 * Menu Creator
 */

(function ($) {

    'use strict';

    /**
     *
     * @param menuEntries
     * @constructor
     */
    var Menu = function (menuEntries) {

        this.menuEntryTemplate =
            '<li class="menu-entry list-group-item sortable">' +
                '<p class="label">{{ title }}</p>' +
                '<small class="url">{{ url }}</small>' +
                '<p><a href="#" class="text-danger delete"></a></p>' +
            '</li>';
        this.menuEntries    = menuEntries;
    };

    Menu.prototype.addEntry = function (data) {

        this.menuEntries.append(
            this.renderMenuEntry(data)
        );
    };


    Menu.prototype.renderMenuEntry = function (data) {

       return this.render(this.menuEntryTemplate, data);
    };

    Menu.prototype.render = function (template, data) {

        for (var key in data) {
            var regularExpression = new RegExp('{{ ' + key + ' }}', 'ig');
            template = template.replace(regularExpression, data[key])
        }

        return template;
    };

    /**
     * @param menu
     * @constructor
     */
    var MenuForm = function (menu) {

        this.menu = menu;
    };

    MenuForm.prototype.addInput = function (name, value) {

        var input   = document.createElement('input');
        input.name  = name;
        input.value = value;
        input.type  = 'hidden';

        this.menu.append(input);

        return this;
    };

    MenuForm.prototype.submit = function () {
        this.menu.submit();
    };

    /**************************************************************************
     * Main
     *************************************************************************/

    var $links              = $('#links');
    var $pages              = $('#pages');
    var $menuEntries        = $('.menu-entries');
    var menu                = new Menu($menuEntries);

    $menuEntries.sortable();

    /**************************************************************************
     * Controls
     *************************************************************************/

    $('.add-pages').click($pages, function () {

        $pages
            .find('input[type="checkbox"]')
            .each(function () {
                var $this       = $(this);
                var isChecked   = $this.prop('checked');

                if (!isChecked) {
                    return;
                }

                $this.prop('checked', false);

                var data = {
                    title: $this.siblings('.title').text(),
                    url: window.location.host + '/' + $this.siblings('.slug').text()
                };

                menu.addEntry(data);
            });
    });

    $('.add-link').click($links, function () {

        var data = {
            title: $links.find('input[name="label"]').val(),
            url: $links.find('input[name="link"]').val()
        };

        menu.addEntry(data);
    });

    $menuEntries.on('click', '.delete', function (event) {
        event.preventDefault();

        var $link = $(event.target);

        $link.closest('.menu-entry').remove();
    });

    /**************************************************************************
     * Forms
     *************************************************************************/

    $(document.forms['menu-creation-form']).submit(function (event) {

        event.preventDefault();

        var $this       = $(this);
        var $menuForm   = $(document.forms['menu-form']);
        var menuForm    = new MenuForm($menuForm);

        var menuName   = $this.find('input[name="name"]').val();

        menuForm.addInput('name', menuName );

        $menuEntries
            .find('.menu-entry')
            .each(function (index, entry) {

            var $entry  = $(entry);
            var label   = $entry.find('.label').text();
            var url     = $entry.find('.url').text();

            menuForm.addInput('entries[' + index + '][position]', index);
            menuForm.addInput('entries[' + index + '][label]', label);
            menuForm.addInput('entries[' + index + '][url]', url);
        });

        menuForm.submit();
    });
})($);
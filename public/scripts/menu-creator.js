/* globals $ */

/**
 * Menu Creator
 */

(function ($) {

    'use strict';

    /**************************************************************************
     * jQuery Objects
     *************************************************************************/

    var $links              = $('#links');
    var $pages              = $('#pages');
    var $menuEntries        = $('.menu-entries');
    var $menuContainer      = $('.menu-container');
    var $addPages           = $('.add-pages');
    var $addLink            = $('.add-link');
    var $selectedMenu       = $menuContainer;

    /**************************************************************************
     * Objects
     *************************************************************************/

    /**
     *
     * @param menuEntries
     * @constructor
     */
    var Menu = function (menuEntries) {

        this.menuEntryTemplate =
            '<li class="menu-entry list-group-item">' +
            '<div class="content">' +
            '<p class="label">{{ title }}</p>' +
            '<small class="url">{{ url }}</small>' +
            '<p>' +
            '<a href="#" class="text-danger delete"></a>' +
            '<a href="#" class="text-info select"></a>' +
            '</p>' +
            '</div>' +
            '<ul class="menu-entries list-group-item" >' +
            '</ul>' +
            '</li>';
        this.menuEntries = menuEntries;
    };

    Menu.prototype.addEntry = function (data) {

        var $newEntry = $(this.renderMenuEntry(data));

        this.menuEntries.append($newEntry);
    };

    Menu.prototype.renderMenuEntry = function (data) {

        return this.render(this.menuEntryTemplate, data);
    };

    Menu.prototype.render = function (template, data) {

        for (var key in data) {
            var regularExpression = new RegExp('{{\\s*' + key + '\\s*}}', 'ig');
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

    var menu            = new Menu($menuEntries);

    /**************************************************************************
     * Controls
     *************************************************************************/

    $menuEntries.sortable();

    $addPages.click($pages, function () {
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

    $addLink.click($links, function () {
        var data = {
            title: $links.find('input[name="label"]').val(),
            url: $links.find('input[name="link"]').val()
        };

        menu.addEntry(data);
    });

    $menuEntries.on('click', '.delete', function (event) {
        event.preventDefault();

        var $link = $(event.target);
        var $menuEntry = $link.closest('.menu-entry');

        if ($menuEntry.hasClass('selected')) {
            $selectedMenu = $menuEntry
                .parents('.menu-entry')
                .addClass('selected');

            menu.menuEntries = $selectedMenu.children('.menu-entries').sortable();
        }

        $menuEntry.remove();
    });

    $menuContainer.on('click', '.select', function (event) {
        event.preventDefault();

        var $link       = $(event.target);
        var $menuEntry  = $link.closest('.menu-entry');

        $selectedMenu.removeClass('selected');

        $selectedMenu = $menuEntry.addClass('selected');
        menu.menuEntries = $selectedMenu.children('.menu-entries').sortable();
    });

    /**************************************************************************
     * Forms
     *************************************************************************/

    var addEntries = function ($entries, menuForm, level) {

        $entries.children('.menu-entry').each(function (index, entry) {

            var $entry      = $(entry);
            var label       = $entry.find('.label').text();
            var url         = $entry.find('.url').text();
            var parentName  = level + '[' + index + ']';

            menuForm.addInput(parentName + '[position]', index);
            menuForm.addInput(parentName + '[label]', label);
            menuForm.addInput(parentName + '[url]', url);

            addEntries(
                $entry.children('.menu-entries'),
                menuForm,
                parentName + '[subEntries]'
            );
        });
    };

    $(document.forms['menu-creation-form']).submit(function (event) {

        event.preventDefault({
            toleranceElement: '> div'
        });

        var $this       = $(this);
        var $menuForm   = $(document.forms['menu-form']);
        var menuForm    = new MenuForm($menuForm);

        var menuName   = $this.find('input[name="name"]').val();

        menuForm.addInput('name', menuName );

        addEntries(
            $menuContainer.children('.menu-entries'),
            menuForm,
            'entries'
        );

        menuForm.submit();
    });
})($);

/*
 Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
 */
CKEDITOR.addTemplates("default",
        {
            imagesPath: CKEDITOR.getUrl(CKEDITOR.plugins.getPath("templates") + "my_templates/images/"),
            templates:
                    [
                        {
                            title: "Szöveg dobozban",
                            image: "szoveg_dobozban.jpg",
                            description: "Szöveg dobozban",
                            html: '<div class="well">Nullam tincidunt gravida erat, vel faucibus ligula luctus a.&nbsp;</div>'
                        },
                        {
                            title: "Idézet",
                            image: "idezet.jpg",
                            description: "Szöveg kiemelése idézetként",
                            html: '<blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p></blockquote>'
                        },
                        {
                            title: "Lista elem",
                            image: "list.jpg",
                            description: "Pipával ellátott lista",
                            html: '<ul><li><i class="fa fa-check"></i>&nbsp;Lorem ipsus lures</li><li><i class="fa fa-check"></i>&nbsp;Lorem ipsus lures</li><li><i class="fa fa-check"></i>&nbsp;Lorem ipsus lures</li><li><i class="fa fa-check"></i>&nbsp;Lorem ipsus lures</li><li><i class="fa fa-check"></i>&nbsp;Lorem ipsus lures</li><li><i class="fa fa-check"></i>&nbsp;Lorem ipsus lures</li></ul>'
                        },
                        {
                            title: "Gomb linkkel",
                            image: "gomb_link.jpg",
                            description: "Linket tartalmazó további részletek gomb",
                            html: '<a class="btn btn-primary" href="">Szöveg »</a>'
              },
                        {
                            title: "Link",
                            image: "link_arrow.jpg",
                            description: "Egyszerű link nyíllal",
                            html: '<p><a href="" class="h5">További információ <i class="fa fa-arrow-right"</i></a></p>'
                      },
                        {
                            title: "Kép beszúrása",
                            image: "kep_beszuras.jpg",
                            description: "Formázott kép beszúrása",
                            html: '<img class="img-thumbnail" alt="" src="/uploads/images/placeholder.jpg">'
                        },
                        {
                            title: "Táblázat 3x2 beszúrása",
                            image: "tablazat_beszuras.jpg",
                            description: "3x2-es táblázat beszúrása",
                            html: '<table class="table table-striped table-hover"><thead><tr><th> Megnevezés </th><th> Ár </th></tr></thead><tbody><tr><td> Félpanzióval </td><td> 20000 Ft </td></tr><tr><td> Teljes ellátás </td><td> 25000 Ft </td></tr><tr><td> Ellátás nélkül </td><td> 15000 Ft </td></tr></tbody></table>'
                        }
                        
                    ]
        });
        
        
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
                            html: '<a class="btn btn-ghost" href="">Szöveg »</a>'
              },
                        {
                            title: "Link",
                            image: "link_arrow.jpg",
                            description: "Egyszerű link nyíllal",
                            html: '<p><a href="#"><i class="fa fa-arrow-right"></i> További információ</a></p>'
                      },
                        {
                            title: "Facebook esemény link",
                            image: "csatlakozom.jpg",
                            description: "Facebook eseményhez kép linkkel",
                            html: '<div class="text-center well"><p>Csatlakozz a Facebook-on az eseményhez, jelöld be, hogy "ott leszel", utána hívj meg legalább 10 gyerekes ismerőst, és a felnőttjegyet ajándékban kapod. A csatlakozáshoz kattints az alábbi grafikára:</p><a href="" target="_blank"><img alt="" src="/uploads/images/csatlakozom.jpg" style="width: 250px; height: 83px;" /></a></div>'
                        },
                        {
                            title: "Kép beszúrása",
                            image: "kep_beszuras.jpg",
                            description: "Formázott kép beszúrása",
                            html: '<img class="img-thumbnail kep-beszuras" alt="" src="/uploads/images/placeholder.jpg">'
                        }
                    ]
        });
define([
    'jquery',
    'uiComponent',
    'Magento_Shipping/js/model/config'

], function ($, Component, config) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'MDL_CustomShipments/shipping/shipping-policy'
        },
        config: config(),
        appendScrollbar: function (element) {
            $(element).scrollbar();
        }
    });
});

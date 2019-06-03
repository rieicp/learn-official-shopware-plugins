Ext.define('Shopware.apps.SwagBundle.store.Bundle', {
    extend: 'Shopware.store.Listing',

    configure: function () {
        return {
            controller: 'SwagBundle'
        };
    },

    model: 'Shopware.apps.SwagBundle.model.Bundle'

    //todo The store needs to "know" its model, additionally the PHP controller must be defined in the `configure` function
    // https://developers.shopware.com/developers-guide/backend-components/basics/#the-data-store-swag_product/store/product.js
});

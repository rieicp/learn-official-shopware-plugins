Ext.define('Shopware.apps.SwagBundle.model.Bundle', {
    extend: 'Shopware.data.Model',

    configure: function () {
        return {
            controller: 'SwagBundle'
        };
    },

    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'name', type: 'string' },
        { name: 'active', type:'boolean' }
    ]

    //todo Implement
    //  - the model fields
    //  - the `configure` function in order to configure the connection to the PHP backend controller
    // https://developers.shopware.com/developers-guide/backend-components/basics/#the-data-model-swag_product_basic/model/product.js
});

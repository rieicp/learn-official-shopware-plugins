Ext.define('Shopware.apps.SwagBundle', {
    extend: 'Enlight.app.SubApplication',

    name: 'Shopware.apps.SwagBundle',

    loadPath: '{url action=load}',
    bulkLoad: true,

    controllers: [ 'Main' ],

    views: [
        'list.Window',
        'list.Bundle'
    ],

    models: [ 'Bundle' ],
    stores: [ 'Bundle' ],

    launch: function () {
        return this.getController('Main').mainWindow;
    }
});

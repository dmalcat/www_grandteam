<h1 class="clanek_title">SKLAD</h1>
<div class="eshop_sklad">
    <div id="editor-grid"></div>
</div>

{literal}
<script type="text/javascript">
//<![CDATA[
Ext.onReady(function(){

    Ext.util.Format.comboRenderer = function(combo){
        return function(value){
            var record = combo.findRecord(combo.valueField, value);
            return record ? record.get(combo.displayField) : "";
        }
    }

    var zobrazit = new Ext.grid.CheckColumn({
               header: 'Zobrazit',
               dataIndex: 'zobrazit',
               width: 55
            });

    var doporucujeme = new Ext.grid.CheckColumn({
               header: 'Doporučujeme',
               dataIndex: 'doporucujeme',
               width: 40
            });
				
    var heurekaKategorie = new Ext.form.ComboBox({
                typeAhead: true,
                triggerAction: 'all',
               // transform the data already specified in html
                transform: 'heurekaKategorie',
                lazyRender: true,
                listClass: 'x-combo-list-small'
            });
				



    // the column model has information about grid columns
    // dataIndex maps the column to the specific data field in
    // the data store (created below)
    var cm = new Ext.grid.ColumnModel([zobrazit, {
            header: 'Název',
            dataIndex: 'nazev',
            width: 200
        },{
            header: 'Obrázek',
            dataIndex: 'obrazek',
            hidden: true,
            width: 50
        },{
            header: 'Skladem',
            dataIndex: 'skladem',
            width: 70,
            // use shorthand alias defined above
            editor: new Ext.form.TextField({
                allowBlank: true
            })
        },{
            header: 'Kod',
            dataIndex: 'kod',
            width: 100,
            // use shorthand alias defined above
            editor: new Ext.form.TextField({
                allowBlank: true
            })
        },{
            header: 'Ean',
            dataIndex: 'ean',
            width: 100,
            // use shorthand alias defined above
            editor: new Ext.form.TextField({
                allowBlank: true
            })
        },{
            header: 'Cena s DPH',
            dataIndex: 'cenaSDph',
            width: 80,
            // use shorthand alias defined above
            editor: new Ext.form.TextField({
                allowBlank: false
            })
        },{
            header: 'Kategorie Heureka',
            dataIndex: 'idHeurekaKategorie',
            width: 225,
            renderer: Ext.util.Format.comboRenderer(heurekaKategorie),
            editor: heurekaKategorie
        },{
            header: 'Název ZBOŽÍ.CZ',
            dataIndex: 'nazev_zbozi_cz',
            width: 131,
            // use shorthand alias defined above
            editor: new Ext.form.TextField({
                allowBlank: true
            })
        }

    ]);

    var proxy = new Ext.data.HttpProxy({
        api: {
            read : '/res/ajax.php?mode=adminStore',
            update: '/res/ajax.php?mode=adminStore&save=1',
            destroy: '//res/ajax.php?mode=adminStore&delete=1'
        }
    });

    var reader = new Ext.data.JsonReader({
        idProperty: 'id',
        successProperty: 'success',
        root: 'produkty',
        totalProperty: 'celkem'
    }, [
        {name: 'nazev'},
	{name: 'nazev_zbozi_cz'},
        {name: 'doporucujeme'},
        {name: 'puvodniCena'},
        {name: 'obrazek'},
        {name: 'skladem'},
        {name: 'cena'},
        {name: 'cenaSDph'},
        {name: 'zobrazit'},
        {name: 'kod'},
	{name: 'ean'},
	{name: 'idHeurekaKategorie'},
    ]);

    // The new DataWriter component.
    var writer = new Ext.data.JsonWriter({
        encode: true,
        writeAllFields: false
    });

    var store = new Ext.data.Store({
        proxy: proxy,
        reader: reader,
        writer: writer,
        autoLoad: true,
        autoSave: false,
        baseParams :{
            start: 0,
            limit: 50,
            id_category: {/literal} {$smarty.post.id_category|default:1}{literal}
        },
        listeners: {
            write : function(kolo, action, result, res, rs) {
                this.reload();
            },
            exception : function(proxy, type, action, options, res, arg) {
                if (type === 'remote') {
                    Ext.Msg.show({
                        title: 'REMOTE EXCEPTION',
                        msg: res.message,
                        icon: Ext.MessageBox.ERROR,
                        buttons: Ext.Msg.OK
                    });
                }
            }
        }
    });

    pagingBar = new Ext.PagingToolbar({
        pageSize: 50,
        store: store,
        emptyMsg: "Žádné chyby"
    });

    // create the editor grid
    var grid = new Ext.grid.EditorGridPanel({
        store: store,
        cm: cm,
        sm: new Ext.grid.RowSelectionModel({singleSelect:true}),
        renderTo: 'editor-grid',
        title: 'Sklad',
        frame: true,
        clicksToEdit: 1,
        autoHeight: true,
        bbar: pagingBar,
        plugins: [doporucujeme, zobrazit],
        tbar: [{
            text: 'Smazat',
            cls: 'x-btn-text-icon delete',
            handler: function(){
                var rec = grid.getSelectionModel().getSelected();
                if (!rec) {
                    return false;
                }

                Ext.MessageBox.show({
                   title:'Smazat produkt?',
                   msg: 'Opravdu chete produkt smazat?',
                   buttons: Ext.MessageBox.YESNO,
                   fn: function(btn){
                       if(btn == 'yes'){
                           grid.getStore().remove(rec);
                           grid.getStore().save();
                       }
                   }
               });

            }
        },'-',{
            text: 'Uložit',
            cls: 'x-btn-text-icon save',
            handler : function(){
                // access the Record constructor through the grid's store
                grid.getStore().save();
            }
        }]
    });
});
//]]>
</script>
{/literal}

{html_options name="heurekaKategorie" id="heurekaKategorie" options=Heureka::getAllCategoriesRecursively(1298)|select:'id':'name' style="display: none;"}
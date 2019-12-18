$('#add-image').click(function () { // Recuperation du numero des futurs champs
    const index = + $('#widgets-counter').val();
    
    // Recuperation du prototype des entrées
    const tmpl = $('#ad_images').data('prototype').replace(/_name_/g, index);
    
    // Injection du code au sein de la div
    $('#ad_images').append(tmpl);
    
    $('#widgets-counter').val(index + 1);
    
    // Bouton supprimer
    handleDeleteButtons();
    });
    
    function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function () {
    const target = this.dataset.target;
    $(target).remove();
    
    });
    }
    
    function updateCounter(){
        const count = +$('#add_images div.form-group').length;
        $('#widgets-counter').val(count);
    }
    
    
    updateCounter();
    handleDeleteButtons();
function AlertIt(id) {
    var answer = confirm ("Do you realy want to delete record with id: " + id)
    if (answer){
        if (typeof (id) == "number"){
            window.location="/contacts/delete/" + id;
        }
    }
}
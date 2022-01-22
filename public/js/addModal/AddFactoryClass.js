
// import AddBaseClass from "./AddBaseClass.js"
// const AddBaseClass = require("./AddBaseClass.js").AddBaseClass;

class AddFactoryClass extends AddBaseClass {
    constructor() {
        // $('.table-responsive').attr('data-link')
        super('factories');

    }

    test_func(){
        console.log(this.link);
    }
}

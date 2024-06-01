const general = {

    createFieldInput(name, label_name, valueinp, typeinp, appendtoelement){

        let lb = document.createElement('label');
        let inp = document.createElement('input')

        inp.type = typeinp;
        inp.value = valueinp == null ? 'N/A' : valueinp;
        inp.id = name;

        lb.innerText = label_name;
        lb.htmlFor = name;

        lb.append(inp);

        appendtoelement.append(lb);

    }

}

export {general}
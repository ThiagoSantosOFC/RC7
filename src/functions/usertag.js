/*
For create user tag just concat nome # num
For example: @user#1234

For read user tag cut the string in two using the # for reference
For example: @user#1234 -> @user and 1234
*/

function createTag(nome, tag){
    return nome + "#" + tag;
}

function readTag(tagstring){
    let nome = "";
    let tag = "";

    for(let i = 0; i < tagstring.length; i++){
        if(tagstring[i] == "#"){
            tag = tagstring.substring(i + 1, tagstring.length);
            break;
        }
        nome += tagstring[i];
    }

    // Return obj
    return {
        nome: nome,
        tag: tag
    }
}

// Test
// console.log(createTag("Pedro", "1234"));
// console.log(readTag("@user#1234"));

// Export
module.exports = {
    createTag: createTag,
    readTag: readTag
}
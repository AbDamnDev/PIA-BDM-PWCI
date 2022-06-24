function goToNotice(myid,container){
    let mytitle=new String(container.parent().parent().attr('data-title'));
    mytitle=mytitle.replace(/ /g,"_");
    window.location='single_page.php?title='+mytitle+'&newsid='+myid;
}
async function  handlerResponse(res){
    const content=await res.text();
    try{
        const jsonData = JSON.parse(content);
        return jsonData;
    }catch(e){
        alert(content);
        return {result:false};
    }
}
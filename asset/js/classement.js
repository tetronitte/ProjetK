var classement=[
    {
        nom : "mickael",
    points : "4000pts"
},
    {
        nom : "lee",
    points : "3999pts"
},
    {
        nom : "clementine",
    points : "3990"
},
    {
        nom : "paul",
    points : "3800pts"
},
    {
        nom : "antoine",
    points : "3799pts"
},
    {
        nom : "frederic",
    points : "3790pts"
},
    {
        nom : "cyril",
    points : "3780pts"
},
    {
        nom : "killian",
    points : "3750pts"
},
    {
        nom : "nathan",
    points : "3740pts"
},
    {
        nom : "mélina",
    points : "3730pts"
},
    {
        nom : "coline",
    points : "3720pts"
},
    {
        nom : "anaïs",
    points : "3680pts"
},
    {
        nom : "celia",
    points : "3620pts"
},
    {
        nom : "stephanie",
    points : "3430pts"
},
    {
        nom : "celeste",
    points : "3330pts"
},
    {
        nom : "camille",
    points : "3200pts"
},
    {
        nom : "lillian",
    points : "3100pts"
},
    {
        nom : "lee-mickael",
    points : "3000pts"
}
];

var list_group = document.getElementById("list-group");
var i=0;

classement.forEach((item) =>{
    i++
    list_group.innerHTML+="<li class='list-group-item'>"+i+" . "+ item.nom +" - "+ item.points+"</li>";
});





      
        
      
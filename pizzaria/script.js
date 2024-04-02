//funcao para automatizar o query selector
//duas formas
//const c=(el)=>document.querySelector(el);
const c =(el)=>{
     return document.querySelector(el);
}
//index é a osição no array   comecando por 0   e item é o objeto ex Em cada iteração do map(), item seria um desses objetos. Por exemplo, na primeira iteração, item seria o objeto:


// { id: 1, name: 'Mussarela', img: 'images/pizza.png', price: 20.19, sizes: ['100g', '530g', '860g'], description: 'Descrição da pizza em mais de uma linha muito legal bem interessante' }
// E na segunda iteração, item seria o objeto:


// { id: 2, name: 'Calabresa', img: 'images/pizza2.png', price: 18.00, sizes: ['320g', '530g', '860g'], description: 'Descrição da pizza em mais de uma linha muito legal bem interessante' }
// E assim por diante, para cada objeto no array pizzaJson. Então, o item é simplesmente uma variável que contém o objeto atual que está sendo processado no loop.
pizzaJson.map((item, index) =>{
    //clonando
let pizzaItem = c('.models .pizza-item').cloneNode(true);


pizzaItem.querySelector('.pizza-item--desc').innerHTML = item.desc;
pizzaItem.querySelector('.pizza-item--price').innerHTML = `R$ ${item.price.toFixed(2)}`;
pizzaItem.querySelector('.pizza-item--name').innerHTML = item.name;
pizzaItem.querySelector('.pizza-item--desc').innerHTML = item.desc;

//document.querySelector('.pizza-area').append(pizzaItem);
c('.pizza-area').append(pizzaItem);

});
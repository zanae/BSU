// Хранимые процедуры MongoDB
// Прямоугольный треугольник задан гипотенузой и одним из катетов. Найти второй катет и площадь треугольника.
function LegS(h, l1) {
  l2 = Math.sqrt(h * h - l1 * l1);
  s = (l1*l2)/2;
  return { 'l' : l2, 's' : s };
};
// Пример использования: LegS(5, 3)
let t = LegS(5, 3); console.log(t);

/* Даны три положительных числа. Если они могут быть длинами сторон остроугольного треугольника, то вывести их в порядке убывания
 и вычислите площадь полученного треугольника, иначе выдать соответствующее сообщение. */
function SideS(A, B, C) {
  if((A+B>C && A+C>B && C+B>A) && (A**2 + B**2 > C**2 || A**2 + C**2 > B**2 || C**2 + B**2 > A**2))
  {
    let sides = [A, B, C];
    sides = sides.sort();
    let p = (A+B+C)/2;
    let s = Math.sqrt(p*(p-A)*(p-B)*(p-C));
    console.log(sides); console.log(s);
    return {"стороны" : sides, "площадь":s}
  }
  else console.log('Это не остроугольный треугольник');
}
/*SideS(2.1, 2.3, 1.7);
SideS(5, 5, 5);
SideS(1.7, 2.3, 2.1); 
SideS(1, 2, 5);
SideS(3, 3.2, 2.6);*/

//Определить количество цифр в представлении натурального числа N в семеричной системе.
function Sev(N) {
    let s = N;
    let rem = [];
    if (N = 0)
        rem.push(0);
    while (s > 0)
    {
        s = Math.floor(s/7);
        // console.log(Math.floor(s/7), ',', s%7);
        rem.push(s%7);
        // наиленивейшая реализация, но задачу выполняет
    }
    return rem.length;
}
/*
Sev(999999)
11333310 -> 8
*/
// Регистрация нового работника (ФИО, зарплата, логин, пароль). Произвести проверку на существование такого же логина и выбросить соответствующую ошибку.
function Register(f, i, o, z, lgn, pwd) {
    if (lgn == '' || lgn == null)
    {
        console.log('Логин некорректен.');
        return null;
    }
    if (db.users.findOne({login : lgn}) != null) { // Не проверяет регистры
        console.log('Логин занят.');
        return null;
    }
    else
    {
        console.log('Логин свободен.');
        let oid = ObjectId();
        db.users.insertOne({_id : oid, login : lgn, password : pwd, 
        last_login : Date(), is_active : true });
        db.stuff.insertOne({_id : oid, family : f, name : i, patronymic : o, 
        hire_date : Date(), salary : z, position_id : 0});
        return oid;
    }
}
// Register('Lyo', 'L', 'Lich', 15, 'POFIJ', 'oeifj');

// Аутентификация пользователя по логину и паролю. Вернуть первичный ключ аутентифицированного пользователя.
function Auth(lgn, pwd) {
    if (db.users.findOne({login : lgn, password : pwd}))
    {
        let u = db.users.find({login : lgn, password : pwd}, {_id : 1});
        //console.log(u);
        return u;
    }
    else
    {
        console.log("Неверный логин или пароль.");
    }
}
// Auth('POFIJ', 'oeifj');
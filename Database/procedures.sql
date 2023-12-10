-- Прямоугольный треугольник задан двумя катетами. Вычислить радиусы вписанной и описанной окружности.
DROP PROCEDURE IF EXISTS Triangle;
DELIMITER //
CREATE PROCEDURE Triangle(IN a INT, b INT, OUT rad1 FLOAT, rad2 FLOAT) 
BEGIN 
	-- DECLARE с FLOAT DEFAULT 0; SET c = SQRT(a*a + b*b);
    -- SELECT c;
 SET rad1 = SQRT(a*a + b*b)/2; 
    -- SET rad1 = c/2; 
     SET rad2 = (a+b-SQRT(a*a + b*b))/2;
    -- SET rad2 = (a+b-c)/2; 
    SELECT rad1, rad2;
END; 
//
DELIMITER ;

CALL Triangle(3, 4, @r1, @r2);
SELECT @r1, @r2;

-- Даны три положительных числа. Если они могут быть длинами сторон разностороннего остроугольного треугольника, то вывести их в порядке возрастания, иначе выдать соответствующее сообщение.
DROP PROCEDURE IF EXISTS Sides;
DELIMITER //
CREATE PROCEDURE Sides(IN a FLOAT, b FLOAT, c FLOAT) 
BEGIN 
-- DECLARE max_side FLOAT DEFAULT 0;
	IF ((a < b+c) AND (b < a+c) AND (c < b+a) AND a != b AND b != c AND c != b) THEN 
		BEGIN
        CASE WHEN (a > b AND a > c AND a*a < (b*b+c*c)) THEN 
			BEGIN
				IF (b > c) THEN select c, b, a; 
				ELSE SELECT b, c, a; END IF;
            END;
		WHEN (b > a AND b > c AND b*b < (c*c+a*a)) THEN 
			BEGIN
				IF (a > c) THEN select c, a, b; 
				ELSE SELECT a, c, b; END IF;
			END;
		WHEN (c > a AND c > b AND c*c < (a*a+b*b)) THEN  
			BEGIN
				IF (a > b) THEN select b, a, c; 
				ELSE SELECT a, b, c; END IF;
			END;
		ELSE 
			SELECT "Это не разносторонний остроугольный треугольник";
        END CASE;
        END;
    ELSE SELECT "Это не разносторонний остроугольный треугольник";
    END IF;
END; //
DELIMITER ;
-- DROP procedure Sides;
CALL sides(2.1, 2.3, 1.7);
CALL sides(5, 5, 5);
CALL sides(1.7, 2.3, 2.1);
CALL sides(1, 2, 5);
CALL SIDES(3, 3.2, 2.6);

-- Получить сумму первой и последней цифры натурального числа N, представленного в пятеричной системе счисления.
DROP PROCEDURE IF EXISTS Fiver;
DELIMITER //
CREATE PROCEDURE Fiver(IN a INT, OUT s INT) 
BEGIN 
	DECLARE m INT DEFAULT 0;
    DECLARE finum VARCHAR(9) DEFAULT '';
	-- SET s = LEFT(a, 1) + RIGHT(a, 1);
    SET m = a;
    fivefold: WHILE m > 0 DO
		BEGIN
			SET finum = CONCAT(finum, m MOD 5);
			SET m = m DIV 5;
		END;
    END WHILE fivefold;
    SET finum = CONCAT(LEFT(REVERSE(finum), 1), RIGHT(REVERSE(finum), 1));
    SET s = CAST(finum AS unsigned);
    SET s = left(s, 1) + right(s, 1);
    SELECT s;
END; 
//
DELIMITER ;
CALL Fiver(123456, @s); -- 12422311
CALL Fiver(5, @s);
CALL Fiver(31, @s);
CALL Fiver(25, @s);
SELECT CONCAT(LEFT(123, 1), RIGHT(123, 1));

		-- Код генерации данных в DB_Lab8
-- Увольнение сотрудников, заходивших в систему более 1 месяц назад. Каждому уволенному заблокировать доступ в систему.
DROP PROCEDURE IF EXISTS Fired;
DELIMITER //
CREATE PROCEDURE Fired() 
BEGIN 
/*DECLARE done BOOLEAN default FALSE;
DECLARE fireid INT default 0;
DECLARE cur CURSOR FOR		SELECT user.id FROM user JOIN stuff ON stuff.id = user.id WHERE 
    user.last_login < (CURRENT_DATE - INTERVAL 1 MONTH) AND ISNULL(stuff.dismissal_date);
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = True;
open cur;*/
-- все ид, фио, логин, увольнение ДО ИЗМЕНЕНИЙ
SELECT user.id, concat_ws(' ', family, name, patronymic), last_login, dismissal_date, is_active, 
IF((ISNULL(stuff.dismissal_date) AND is_active = 1) OR (NOT ISNULL(stuff.dismissal_date)) 
AND is_active = 0, 'ОК', 'Что-то пошло не так...'), COUNT(stuff.id) OVER() 
FROM user JOIN stuff ON stuff.id = user.id;
 -- все, кого не надо увольнять
SELECT user.id, concat_ws(' ', family, name, patronymic), last_login, dismissal_date, is_active, COUNT(stuff.id) OVER() FROM user JOIN stuff ON stuff.id = user.id WHERE 
user.last_login >= (CURRENT_DATE - INTERVAL 1 MONTH) AND ISNULL(stuff.dismissal_date);
SELECT user.id, concat_ws(' ', family, name, patronymic), last_login, dismissal_date, is_active, COUNT(stuff.id) OVER() FROM user JOIN stuff ON stuff.id = user.id WHERE 
user.last_login < (CURRENT_DATE - INTERVAL 1 MONTH) AND ISNULL(stuff.dismissal_date); -- кого надо
	UPDATE stuff SET dismissal_date = CURRENT_DATE WHERE id IN (	SELECT user.id FROM user 
	JOIN stuff ON stuff.id = user.id WHERE user.last_login < (CURRENT_DATE - INTERVAL 1 MONTH) 
	AND ISNULL(stuff.dismissal_date)	)
/*upd: LOOP
FETCH cur INTO fireid;
	IF done THEN LEAVE upd; 
	END IF;
	UPDATE stuff SET dismissal_date = CURRENT_DATE
    WHERE id = fireid;
    UPDATE user SET is_active = FALSE WHERE id = fireid;
END LOOP;*/
-- всё после изменений
SELECT user.id, concat_ws(' ', family, name, patronymic), last_login, dismissal_date, is_active, IF((ISNULL(stuff.dismissal_date) AND is_active = 1) OR (NOT ISNULL(stuff.dismissal_date)) AND is_active = 0, 'ОК', 'Что-то пошло не так...'), COUNT(stuff.id) OVER() FROM stuff JOIN user ON user.id = stuff.id;
-- кто должен был быть уволен 
SELECT user.id, concat_ws(' ', family, name, patronymic), last_login, dismissal_date, is_active, COUNT(user.id) OVER() FROM user JOIN stuff ON stuff.id = user.id WHERE 
user.last_login < (CURRENT_DATE - INTERVAL 1 MONTH) AND dismissal_date = CURRENT_DATE;
-- кто не должен 
SELECT user.id, concat_ws(' ', family, name, patronymic), last_login, dismissal_date, is_active, COUNT(user.id) OVER() FROM user JOIN stuff ON stuff.id = user.id WHERE 
user.last_login >= (CURRENT_DATE - INTERVAL 1 MONTH) AND ISNULL(stuff.dismissal_date);
END; //
DELIMITER ;
DROP PROCEDURE IF EXISTS Fired;
CALL Fired();
SELECT CEIL(5.5), CEIL(5);
-- UPDATE stuff SET salary = 55000 WHERE ISNULL(dismissal_date) OR dismissal_date < '2022-04-10';

-- Подсчет медианной зарплаты сотрудников, числящихся в штате на определенную дату.
DROP FUNCTION IF EXISTS MedianSalary;
DELIMITER //
CREATE FUNCTION MedianSalary(dato DATE) RETURNS FLOAT deterministic
BEGIN
	DECLARE median1, median2, median FLOAT DEFAULT 0;
    SET median1 = (SELECT s FROM (SELECT salary_in_thousands as s, ROW_NUMBER() OVER 
(ORDER BY salary_in_thousands) as r, COUNT(*) OVER () as cnt FROM stuff 
WHERE dismissal_date < dato OR (ISNULL(dismissal_date) AND hire_date < dato)) t WHERE r = CEIL(cnt / 2));
    SET median2 = (SELECT s FROM (SELECT salary_in_thousands as s, ROW_NUMBER() OVER 
(ORDER BY salary_in_thousands) as r, COUNT(*) OVER () as cnt FROM stuff 
WHERE dismissal_date < dato OR (ISNULL(dismissal_date) AND hire_date < dato)) t WHERE r = CEIL(cnt / 2)+1);
    -- UPDATE stuff SET salary_in_thousands = 55000 WHERE dismissal_date < dato OR (ISNULL(dismissal_date) AND hire_date < dato);
    -- SET sal = /*(SELECT salary_in_thousands FROM stuff WHERE dismissal_date < dato OR (ISNULL(dismissal_date) AND hire_date < dato) 
    -- ORDER BY salary_in_thousands);
	IF (SELECT COUNT(*) mod 2 = 0 FROM stuff WHERE dismissal_date < dato OR (ISNULL(dismissal_date) 
AND hire_date < dato)) THEN SET median = (median1 + median2) / 2.0;
	ELSE SET median = median1; END IF;
	RETURN median;
END; //
DELIMITER ; 
DROP FUNCTION IF EXISTS MedianSalary;
SELECT MedianSalary('2022-04-10');

WITH t AS (
SELECT id, salary_in_thousands as s, ROW_NUMBER() OVER (ORDER BY salary_in_thousands) as r, 
COUNT(*) OVER () as cnt FROM stuff WHERE dismissal_date < '2022-04-10' OR 
(ISNULL(dismissal_date) AND hire_date < '2022-04-10'))
SELECT * from t;
	SELECT CASE WHEN COUNT(*) mod 2 = 0 THEN (SELECT AVG(s) FROM t WHERE r BETWEEN CEIL(cnt/2) AND CEIL(cnt/2)+1) 
ELSE (SELECT s FROM t WHERE r = CEIL(cnt/2)) END; 

update stuff set salary_in_thousands = 63 WHERE id = 26;
update stuff set salary_in_thousands = FLOOR(60 + (RAND() * 100)) -- случайное цел [60,100], ранд генерит вещ [0;1]
WHERE salary_in_thousands BETWEEN 56 AND 100;

SELECT * FROM stuff;
-- SELECT CURRENT_DATE(); -- SELECT NOW();
SELECT * FROM _position;
SELECT * FROM user;
SELECT * FROM stuff_position_history;
SELECT * FROM stuff_position_archive;
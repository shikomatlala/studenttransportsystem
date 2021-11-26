-- Find the number of students that are talking busses for a given route
-- Find the number of busses that are going to be take by students.
-- Show a student their bus schedule
-- Assign the busses a trip


SELECT userId, fName, lName, resDate, startTime, endTime, startPoint, destination
FROM `reservation`, `user`, `trip`, `campus` a, `campus` b
WHERE `studentId` =  210674821
AND `userId` = `studentId`
AND `trip`.`tripId` = `reservation`.`tripId`
AND `trip`.`startPoint` = a.`campusId`
AND `trip`.`destination` = b.`campusId`;


SELECT userId, fName, lName, resDate, startTime, endTime, CASE 1 THEN (SELECT `name` FROM `campus` WHERE `campusId`= startPoint), destination
FROM `reservation`, `user`, `trip`, `campus` a, `campus` b
WHERE `studentId` =  210674821
AND `userId` = `studentId`
AND `trip`.`tripId` = `reservation`.`tripId`
AND `trip`.`startPoint` = a.`campusId`
AND `trip`.`destination` = b.`campusId`;



SELECT userId, fName, lName, resDate, startTime, endTime, CASE trip.startPoint 
															WHEN 1 THEN "Acadia Campus"
                                                           END AS "Sosh South", destination
FROM `reservation`, `user`, `trip`, `campus` a, `campus` b
WHERE `studentId` =  210674821
AND `userId` = `studentId`
AND `trip`.`tripId` = `reservation`.`tripId`
AND `trip`.`startPoint` = a.`campusId`
AND `trip`.`destination` = b.`campusId`

-- Show a Student their bus reservation schedule
SELECT userId, fName, lName, resDate, startTime, endTime, (SELECT `name` 
                                                            FROM `campus` 
                                                            WHERE `campusId` = trip.startPoint) startPoint,  
                                                        (SELECT `name` 
                                                            FROM `campus` 
                                                            WHERE `campusId` = trip.destination) destination
FROM `reservation`, `user`, `trip`, `campus` a, `campus` b
WHERE `studentId` =  210674821
AND `userId` = `studentId`
AND `trip`.`tripId` = `reservation`.`tripId`
AND `trip`.`startPoint` = a.`campusId`
AND `trip`.`destination` = b.`campusId`
AND reservation.resDate = CURDATE();


-- Find the number of busses that are going to be taken by students For a given trip.
-- Firstly count the number of students that are going to take busses - For a given trip
SELECT user.userId, fName,  lName, reservation.resDate resDate, startTime, endTime,(SELECT `name` 
                                                            FROM `campus` 
                                                            WHERE `campusId` = trip.startPoint) startPoint, 
                                                            (SELECT `name` 
                                                            FROM `campus` 
                                                            WHERE `campusId` = trip.destination) destination
FROM reservation, user, trip, campus a, campus b
WHERE reservation.tripId = 3
AND trip.tripId = reservation.tripId
AND a.campusId = trip.startPoint
AND b.campusId = trip.destination
AND reservation.studentId = user.userId;




SELECT COUNT(studentId) / 63
FROM reservation
WHERE tripId = 3

SELECT COUNT(studentId) / 63 "Number of Busses", COUNT(studentId) % 63 
FROM reservation
WHERE tripId = 3

-- A single bus will be short of So many students Or rather that bus should allow other students to join in? -- No the rule is that a bus should not be overloaded.
-- For this trip we are going to need to many busses
SELECT COUNT(studentId) / 63, COUNT(studentId) % 63, 63 - (COUNT(studentId) % 63)
FROM reservation
WHERE tripId = 3;


SELECT TRUNCATE(COUNT(studentId) / 63, 0),  COUNT(studentId) % 63, 63 - (COUNT(studentId) % 63)
FROM reservation
WHERE tripId = 3


SELECT ROUND(COUNT(studentId) / 63, 0),  COUNT(studentId) % 63, 63 - (COUNT(studentId) % 63)
FROM reservation
WHERE tripId = 3


SELECT ROUND(COUNT(studentId) / 63, 0) Full, CEILING(COUNT(studentId) / 63) "Ceiling",  COUNT(studentId) % 63 "Reminder", 63 - (COUNT(studentId) % 63) "Empty Seats"
FROM reservation
WHERE tripId = 3

SELECT COUNT(studentId) "totStudents"
FROM reservation
WHERE tripId = 3

--  Assign the busses a trip - Now we need to make sure that we can find the number of busses that are going to be utalized and then from ther we need insert those busses . -- 
-- But also we need to make sure that we assign the right busses or rather busses that are free for that time.
-- We can make use of procedures


SELECT ROUND(COUNT(studentId) / 63, 0) Full, CEILING(COUNT(studentId) / 63) "Ceiling",  COUNT(studentId) % 63 "Reminder", 63 - (COUNT(studentId) % 63) "Empty Seats" , tripId
FROM reservation
WHERE tripId = 3
GROUP BY tripId;

SELECT * 
FROM bus

 -- Find a list of buses that are not occupied or that are not assigned to any trip or that hour
SELECT *
FROM bus, bus_trip
WHERE bus.busId = bus_trip.busId
AND bus.busId NOT IN (SELECT busId FROM bus_trip WHERE tripId = 3);

-- Now we can find all busses that are not occupied
SELECT *
FROM bus
WHERE bus.busId NOT IN (SELECT busId FROM bus_trip WHERE tripId = 3);

 -- Insert a bus where the reservation is of a kind and the buss is also free
INSERT INTO `bus_trip` (busId, tripId, `date`) VALUES (1, 3, (SELECT DISTINCT(resDate) FROM reservation WHERE tripId = 3))

VAR countFreeBusses;


CREATE PROCEDURE freeBusses(p1 INT)
BEGIN
    start1: LOOP
        SET p1 = p1 + 1;
        IF p1 < 10  THEN 
            ITERATE start1; 
        END IF;
        LEAVE start1;
    END LOOP start1;
END;


CREATE PROCEDURE myProcedure()
    CURSOR freeBusses FOR 
        SELECT busId
        FROM bus
        WHERE bus.busId NOT IN (SELECT busId FROM bus_trip WHERE tripId = 3);
    busId bus.busId%TYPE;
    BEGIN
        OPEN freeBusses
        LOOP
            FETCH freeBusses INTO busId;
            -- Now the goal is to Into the database the result of the fetch
            INSERT INTO `bus_trip` (busId, tripId, `date`) VALUES (busId, 3, (SELECT DISTINCT(resDate) FROM reservation WHERE tripId = 3))
            EXIT WHEN freeBusses%NOTFOUND;
        END LOOP
    END;
/
    

CREATE PROCEDURE curdemo()
BEGIN
DECLARE done INT DEFAULT FALSE;
DECLARE a CHAR(16);
DECLARE b, c INT;
DECLARE cur1 CURSOR FOR SELECT id,data FROM test.t1;
DECLARE cur2 CURSOR FOR SELECT i FROM test.t2;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
OPEN cur1;
OPEN cur2;
read_loop: LOOP
FETCH cur1 INTO a, b;
FETCH cur2 INTO c;
IF done THEN
LEAVE read_loop;
END IF;
IF b < c THEN
INSERT INTO test.t3 VALUES (a,b);
ELSE
INSERT INTO test.t3 VALUES (a,c);
END IF;
END LOOP;
CLOSE cur1;
CLOSE cur2;
END;


CREATE PROCEDURE curDemo()
    BEGIN   
        DECLARE done INT DEFAULT FALSE;
        DECLARE vBusId INT;
        DECLARE openBusses FOR
            SELECT busId
            FROM bus
            WHERE bus.busId NOT IN (SELECT busId FROM bus_trip WHERE tripId = 3);
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE; 
        OPEN openBusses;
        read_loop: LOOP 
            FETCH openBusses INTO vBusId;
            IF done THEN    
                LEAVE read_loop;
            END IF;
            INSERT INTO `bus_trip` (busId, tripId, `date`) VALUES (vBusId, 3, (SELECT DISTINCT(resDate) FROM reservation WHERE tripId = 3))
        END LOOP;
        CLOSE openBusses;
    END;

-- OK since we have the right codes we will simply make use of PHP to create a way to store our busses - But what about the timing - should we call the the busses when 15 Minutes before or should we just leave them as is?

-- Insert a bus where into a trip where the bus has not been reserved for a given period of time.
-- But here is where it gets more interesting- Some busses will be starting from somewhere, rather we can assume that all busses start from a given position 
-- In other words this is to mean that all busses have a home so we should not think that other busses are going to start from a given point in time, this is important because it means that we can resign busses a trip on a give day , but one a route has been defined for a bus should we then allow the bus to not take a different route, would not that mean that a buss may be wasted or rather I feel like I can smell some ineffecieny somewhere 


-- Loop through a list of free busses
--     Insert per item on the list
-- End Loop


-- 
-------------------
-- Our test student
--------------------
210674821
Noah Buscemi



-- Well we can that we need to know the number of busses that are full and then we can check how many spaces will be occupied on the third bus and then also tell how many seats will be left empty
-- Now the next question is to make 

-- We are not always going to have the same number of busses - Therefore we need to make sure that can count all the busses that we have for a given, and then count the number of students who can occupy a bus









INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210942661, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210925272, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210917371, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210238027, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210259626, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210752377, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210588876, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210588704, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210809758, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210757370, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210961589, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210304806, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210937504, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210569081, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210674905, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210685075, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210706404, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210429784, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210390625, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210694060, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210160704, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210535348, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210368647, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210161493, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210770087, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210766991, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210166590, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210719557, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210522896, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210919263, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210884931, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210342193, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210448469, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210376547, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210434418, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210352504, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210409240, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210604387, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210316882, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210368104, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210127286, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210952039, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210587484, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210986867, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210239426, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210860087, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210804854, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210339522, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210772526, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210592205, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210572492, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210461004, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210447731, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210628112, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210617936, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210329385, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210565689, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210372346, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210404546, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210904410, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210944926, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210934487, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210513998, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210227085, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210922785, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210749621, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210413596, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210489187, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210462065, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210721752, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210855683, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210617686, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210514186, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210481662, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210553770, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 210513383, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211439692, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211364632, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211240020, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211161921, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211545240, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211782004, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211897172, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211431974, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211195658, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211119424, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211447541, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211342756, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211186538, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211826648, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211221617, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211966842, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211770868, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211758520, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211228531, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211868725, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211841020, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211780560, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211765668, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211567838, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211550378, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211598899, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211468922, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211129213, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211334049, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211445443, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211134905, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211576898, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211365592, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211315473, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211804469, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211802293, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211252296, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211154207, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211692371, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211547863, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211115258, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211983603, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211681733, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211407087, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211456003, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211346767, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211295434, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211713542, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211255713, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211939400, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211673086, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211671864, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211252409, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211939039, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211164459, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211849611, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211371857, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211772242, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211884620, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211426180, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211892511, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211124468, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211855124, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211841104, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211164253, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211390394, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211573186, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211124215, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211496742, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211509485, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211404026, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211336273, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211591973, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211839226, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211320290, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211658038, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211240408, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 211514291, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 212370341, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 212707628, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 212112175, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 212973143, 3);
INSERT INTO `reservation` (`resDate`, `studentId`, `tripId`) VALUES (CURDATE(), 212921034, 3);

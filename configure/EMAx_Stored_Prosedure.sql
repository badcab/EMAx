DELIMITER $$
DROP PROCEDURE IF EXISTS new_cost_of_event $$

CREATE PROCEDURE new_cost_of_event (IN eventID INT)
LANGUAGE SQL
DETERMINISTIC
SQL SECURITY DEFINER
BEGIN
	DECLARE optionVar, gradeVar, roomVar, basecostVar, totalCostVar DECIMAL(6,2) UNSIGNED;
	DECLARE attendanceVar, roomResVar, countyVar INT;

	SELECT `EMAx_Event`.`roomReservation`
		FROM `EMAx_Event`
		WHERE `EMAx_Event`.`ID` = eventID
		INTO roomResVar;

	SELECT `EMAx_Organization`.`sameCounty`
		FROM `EMAx_Organization`
		JOIN `EMAx_Event`
		WHERE `EMAx_Event`.`ID` = eventID
		AND `EMAx_Event`.`EMAx_Organization_ID` = `EMAx_Organization`.`ID`
		INTO countyVar;

	SELECT `EMAx_Event`.`attendance`
		FROM `EMAx_Event`
		WHERE `EMAx_Event`.`ID` = eventID
		INTO attendanceVar;

	IF roomResVar = 0 THEN
		SET roomVar = 0.00;
	ELSE
		SELECT `EMAx_RoomLocation`.`cost`
			FROM `EMAx_RoomLocation`
			JOIN `EMAx_Event`
			WHERE `EMAx_Event`.`ID` = eventID
			AND `EMAx_Event`.`EMAx_RoomLocation_ID` = `EMAx_RoomLocation`.`ID`
			INTO roomVar;
	END IF;

	IF countyVar = 0 THEN

		SELECT `EMAx_CostSettings`.`moneyValue`
			FROM `EMAx_CostSettings`
			WHERE  `EMAx_CostSettings`.`property` = 'outCounty'
			INTO basecostVar;
	ELSE
		SELECT `EMAx_CostSettings`.`moneyValue`
			FROM `EMAx_CostSettings`
			WHERE `EMAx_CostSettings`.`property` = 'inCounty'
			INTO basecostVar;
	END IF;

	SELECT SUM(`EMAx_Option`.`cost`)
		FROM `EMAx_Option`
		JOIN `EMAx_OptionEventMap`
		WHERE `EMAx_Option`.`ID` = `EMAx_OptionEventMap`.`EMAx_Option_ID`
		AND `EMAx_OptionEventMap`.`EMAx_Event_ID` = eventID
		INTO optionVar;

	SELECT SUM(`EMAx_Grade`.`cost`)
		FROM `EMAx_Grade`
		JOIN `EMAx_GradeEventMap`
		WHERE `EMAx_Grade`.`ID` = `EMAx_GradeEventMap`.`EMAx_Grade_ID`
		AND `EMAx_GradeEventMap`.`EMAx_Event_ID` = eventID
		INTO gradeVar;

	SET totalCostVar = ((optionVar + gradeVar + basecost) * attendanceVar) + (roomResVar);

	UPDATE `EMAx_Event` SET(`EMAx_Event`.`cost` = totalCostVar) WHERE `EMAx_Event`.`ID` = eventID;
	--something wrong with this line
END
$$
DELIMITER ;
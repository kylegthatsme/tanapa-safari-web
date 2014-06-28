/*
 * Test DATA Insertion Script.
 */

DELETE FROM SAFARI_POINTS_OF_INTEREST;
DELETE FROM SAFARI_WAYPOINTS;
DELETE FROM REPORT;
DELETE FROM REPORT_TYPE;
DELETE FROM USER_LOG;
DELETE FROM USER;
DELETE FROM SAFARI;
DELETE FROM MEDIA;


INSERT INTO REPORT_TYPE(name) VALUES('Poaching');
INSERt INTO REPORT_TYPE(name) VALUES('Animal Movement');


INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/arusha_safari_header.jpg');
SET @arusha_safari_header_media_id = LAST_INSERT_ID();

INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/arusha_safari_footer.jpg');
SET @arusha_safari_footer_media_id = LAST_INSERT_ID();

INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/arusha_safari_tile.jpg');
SET @arusha_safari_tile_media_id = LAST_INSERT_ID();

INSERT INTO SAFARI(name, description, header_media_id, footer_media_id, tile_media_id)
VALUES('Arusha Safari', 'Tour Arusha park.', @arusha_safari_header_media_id, @arusha_safari_footer_media_id, @arusha_safari_tile_media_id);
SET @arusha_safari_id = LAST_INSERT_ID();


INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('0', '34.681217', '-82.842434', @arusha_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('1', '34.684887', '-82.842777', @arusha_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('2', '34.683787', '-82.842875', @arusha_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('3', '34.680887', '-82.842077', @arusha_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('4', '34.674887', '-82.832777', @arusha_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('6', '34.674897', '-82.842004', @arusha_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('7', '34.681990', '-82.841707', @arusha_safari_id);


INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/kilimanjaro_safari_header.jpg');
SET @kilimanjaro_safari_header_media_id = LAST_INSERT_ID();

INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/kilimanjaro_safari_footer.jpg');
SET @kilimanjaro_safari_footer_media_id = LAST_INSERT_ID();

INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/kilimanjaro_safari_tile.jpg');
SET @kilimanjaro_safari_tile_media_id = LAST_INSERT_ID();

INSERT INTO SAFARI(name, description, header_media_id, footer_media_id, tile_media_id)
VALUES('Kilimanjaro Safari', 'Tour Kilimanjaro.', @kilimanjaro_safari_header_media_id, @kilimanjaro_safari_footer_media_id, @kilimanjaro_safari_tile_media_id);
SET @kilimanjaro_safari = LAST_INSERT_ID();




INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/avana_safari_header.jpg');
SET @avana_safari_header_media_id = LAST_INSERT_ID();

INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/avana_safari_footer.jpg');
SET @avana_safari_footer_media_id = LAST_INSERT_ID();

INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/avana_safari_tile.jpg');
SET @avana_safari_tile_media_id = LAST_INSERT_ID();

INSERT INTO SAFARI(name, description, header_media_id, footer_media_id, tile_media_id)
VALUES('Avana Safari', 'Tour the Avana apartment complex.', @avana_safari_header_media_id, @avana_safari_footer_media_id, @avana_safari_tile_media_id);
SET @avana_safari_id = LAST_INSERT_ID();


INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('0', '34.81902', '-82.310099', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('1', '34.818646', '-82.309235', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('2', '34.819101', '-82.3089', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('3', '34.819484', '-82.308672', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('4', '34.819879', '-82.309541', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('6', '34.820094', '-82.309895', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('7', '34.820605', '-82.309053', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('8', '34.821075', '-82.308277', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('9', '34.821259', '-82.308444', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('10', '34.820789', '-82.309235', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('11', '34.820247', '-82.310136', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('12', '34.819854', '-82.310388', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('13', '34.819574', '-82.310088', @avana_safari_id);
INSERT INTO SAFARI_WAYPOINTS(sequence, latitude, longitude, safari_id) 
    VALUES ('14', '34.819316', '-82.309852', @avana_safari_id);


INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/poi_dogpark.jpg');
SET @avana_dogpark_media_id = LAST_INSERT_ID();

INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/poi_carcare.jpg');
SET @avana_carcare_media_id = LAST_INSERT_ID();

INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/poi_pool.jpg');
SET @avana_pool_media_id = LAST_INSERT_ID();

INSERT INTO SAFARI_POINTS_OF_INTEREST(name, media_id, safari_id, latitude, longitude, radius)
    VALUES("Dog Park", @avana_dogpark_media_id, @avana_safari_id, "34.81953", "-82.308396", 100);
INSERT INTO SAFARI_POINTS_OF_INTEREST(name, media_id, safari_id, latitude, longitude, radius)
    VALUES("Car Care Center", @avana_carcare_media_id, @avana_safari_id, "34.818406", "-82.308873", 100);
INSERT INTO SAFARI_POINTS_OF_INTEREST(name, media_id, safari_id, latitude, longitude, radius)
    VALUES("Pool", @avana_pool_media_id, @avana_safari_id, "34.819437", "-82.309763", 100);



INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/clemson_safari_tile.jpg');
SET @clemson_safari_tile_media_id = LAST_INSERT_ID();

INSERT INTO SAFARI(name, description, header_media_id, footer_media_id, tile_media_id)
VALUES('Clemson Safari', 'Tour Clemson.', null, null, @clemson_safari_tile_media_id);


INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/greenville_safari_tile.jpg');
SET @greenville_safari_tile_media_id = LAST_INSERT_ID();

INSERT INTO SAFARI(name, description, header_media_id, footer_media_id, tile_media_id)
VALUES('Greenville Safari', 'Tour Greenville.', null, null, @greenville_safari_tile_media_id);


INSERT INTO MEDIA(type, url) VALUES ('image/jpeg', '/media/greenville_zoo_safari_tile.jpg');
SET @greenville_zoo_safari_tile_media_id = LAST_INSERT_ID();

INSERT INTO SAFARI(name, description, header_media_id, footer_media_id, tile_media_id)
VALUES('Greenville Zoo Safari', 'Tour Greenville Zoo.', null, null, @greenville_zoo_safari_tile_media_id);


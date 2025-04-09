SELECT title,
       description,
       user_id,
       display_name,
       col1,
       col2,
       services.id        AS id,
       services.latitude  AS latitude,
       services.longitude AS longitude,
       image_banner.url   AS img_banner_url,
       image_main.url     AS img_main_url
FROM services
         JOIN users
              ON users.id = services.user_id
         JOIN themes
              ON services.theme_id = themes.id
         JOIN images AS image_banner
              ON themes.banner_image_id = image_banner.id
         JOIN images AS image_main
              ON themes.main_image_id = image_main.id
WHERE services.id in ($id_request)
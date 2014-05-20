SELECT
  a.*,
  CASE
    WHEN p.PostId IS NOT NULL THEN 'news'
    WHEN e.EventId IS NOT NULL THEN 'calendar'
    WHEN g.GalleryId IS NOT NULL THEN 'gallery'
    ELSE 'site'
  END AS InstanceOf,
  COALESCE(p.PostId,e.EventId,g.GalleryId,s.id) AS InstanceId
FROM
  articles a
  LEFT JOIN posts p ON a.ArticleId=p.ArticleId
  LEFT JOIN EVENTS e ON a.ArticleId=e.ArticleId
  LEFT JOIN galleries g ON a.ArticleId=g.ArticleId
  LEFT JOIN sitemap s ON (a.ArticleId=s.ModuleData AND s.ModuleName='site')

-- where
-- a.ArticleTags='Носталгия'
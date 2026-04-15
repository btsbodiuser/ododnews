import { useParams, Link } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { Clock, Eye, ArrowLeft, Share2 } from 'lucide-react';
import { motion } from 'framer-motion';
import { getArticle } from '@/services/api';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import ArticleCard from '@/components/ArticleCard';
import Trending from '@/components/Trending';
import { Skeleton } from '@/components/ui/skeleton';

export default function ArticlePage() {
  const { slug } = useParams<{ slug: string }>();

  const { data: article, isLoading } = useQuery({
    queryKey: ['article', slug],
    queryFn: () => getArticle(slug!),
    enabled: !!slug,
  });

  if (isLoading) {
    return (
      <div className="max-w-4xl mx-auto px-4 py-8">
        <Skeleton className="h-8 w-3/4 mb-4" />
        <Skeleton className="h-6 w-1/2 mb-8" />
        <Skeleton className="aspect-video rounded-2xl mb-8" />
        <Skeleton className="h-4 w-full mb-2" />
        <Skeleton className="h-4 w-full mb-2" />
        <Skeleton className="h-4 w-3/4" />
      </div>
    );
  }

  if (!article) {
    return (
      <div className="max-w-4xl mx-auto px-4 py-16 text-center">
        <h1 className="text-2xl font-bold mb-4">Мэдээ олдсонгүй</h1>
        <Link to="/">
          <Button>Нүүр хуудас руу буцах</Button>
        </Link>
      </div>
    );
  }

  return (
    <div className="max-w-7xl mx-auto px-4 py-6">
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <motion.article
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          className="lg:col-span-2"
        >
          {/* Back navigation */}
          <Link to="/" className="inline-flex items-center text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white mb-4 transition-colors">
            <ArrowLeft className="w-4 h-4 mr-1" />
            Нүүр хуудас
          </Link>

          {/* Category + badges */}
          <div className="flex items-center gap-2 mb-3">
            {article.category && (
              <Badge style={{ backgroundColor: article.category.color }} className="text-white border-0">
                {article.category.name}
              </Badge>
            )}
            {article.is_breaking && (
              <Badge variant="destructive">ЯАРАЛТАЙ</Badge>
            )}
            {article.is_trending && (
              <Badge variant="secondary">ТРЭНД</Badge>
            )}
          </div>

          {/* Title */}
          <h1 className="text-2xl md:text-4xl font-bold text-gray-900 dark:text-white leading-tight">
            {article.title}
          </h1>

          {/* Meta */}
          <div className="flex flex-wrap items-center gap-4 mt-4 text-sm text-gray-500">
            {article.author && (
              <div className="flex items-center gap-2">
                <Avatar className="w-8 h-8">
                  <AvatarFallback className="text-xs bg-red-100 text-red-600">
                    {article.author.name.charAt(0)}
                  </AvatarFallback>
                </Avatar>
                <Link to={`/author/${article.author.slug}`} className="font-medium text-gray-700 dark:text-gray-300 hover:text-red-600 transition-colors">
                  {article.author.name}
                </Link>
              </div>
            )}
            <span className="flex items-center gap-1">
              <Clock className="w-4 h-4" />
              {article.published_at_human}
            </span>
            <span className="flex items-center gap-1">
              <Eye className="w-4 h-4" />
              {article.views_count.toLocaleString()} үзсэн
            </span>
            <Button variant="ghost" size="sm" className="ml-auto" onClick={() => navigator.clipboard.writeText(window.location.href)}>
              <Share2 className="w-4 h-4 mr-1" />
              Хуваалцах
            </Button>
          </div>

          <Separator className="my-6" />

          {/* Featured image */}
          {article.featured_image && (
            <div className="aspect-video rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-800 mb-8">
              <img
                src={article.featured_image}
                alt={article.title}
                className="w-full h-full object-cover"
              />
            </div>
          )}

          {/* Excerpt */}
          {article.excerpt && (
            <p className="text-lg text-gray-600 dark:text-gray-400 font-medium leading-relaxed mb-6 border-l-4 border-red-600 pl-4">
              {article.excerpt}
            </p>
          )}

          {/* Body */}
          <div
            className="prose prose-lg dark:prose-invert max-w-none prose-headings:font-bold prose-a:text-red-600 prose-img:rounded-xl"
            dangerouslySetInnerHTML={{ __html: article.body || '' }}
          />

          {/* Tags */}
          {article.tags && article.tags.length > 0 && (
            <div className="flex flex-wrap gap-2 mt-8">
              {article.tags.map((tag) => (
                <Link key={tag.id} to={`/search?q=${tag.name}`}>
                  <Badge variant="outline" className="hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    #{tag.name}
                  </Badge>
                </Link>
              ))}
            </div>
          )}

          {/* Author card */}
          {article.author && (
            <div className="mt-8 p-6 bg-gray-50 dark:bg-gray-900 rounded-2xl">
              <div className="flex items-start gap-4">
                <Avatar className="w-14 h-14">
                  <AvatarFallback className="text-lg bg-red-100 text-red-600">
                    {article.author.name.charAt(0)}
                  </AvatarFallback>
                </Avatar>
                <div>
                  <Link to={`/author/${article.author.slug}`} className="font-bold text-lg text-gray-900 dark:text-white hover:text-red-600 transition-colors">
                    {article.author.name}
                  </Link>
                  {article.author.position && (
                    <p className="text-sm text-gray-500">{article.author.position}</p>
                  )}
                  {article.author.bio && (
                    <p className="text-sm text-gray-600 dark:text-gray-400 mt-2">{article.author.bio}</p>
                  )}
                </div>
              </div>
            </div>
          )}

          {/* Related articles */}
          {article.related && article.related.length > 0 && (
            <div className="mt-12">
              <h2 className="text-xl font-bold text-gray-900 dark:text-white mb-6">Холбоотой мэдээ</h2>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {article.related.map((related) => (
                  <ArticleCard key={related.id} article={related} />
                ))}
              </div>
            </div>
          )}
        </motion.article>

        {/* Sidebar */}
        <aside>
          <Trending />
        </aside>
      </div>
    </div>
  );
}

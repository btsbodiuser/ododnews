import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Clock, Eye } from 'lucide-react';
import { Badge } from '@/components/ui/badge';
import type { Article } from '@/types';

interface ArticleCardProps {
  article: Article;
  variant?: 'default' | 'horizontal' | 'featured';
}

export default function ArticleCard({ article, variant = 'default' }: ArticleCardProps) {
  const imageUrl = article.featured_image || '/ododnews/placeholder.jpg';

  if (variant === 'featured') {
    return (
      <motion.article
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="group relative overflow-hidden rounded-2xl bg-gray-900 aspect-[16/9] md:aspect-[21/9]"
      >
        <img
          src={imageUrl}
          alt={article.title}
          className="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-700"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent" />
        <div className="absolute bottom-0 left-0 right-0 p-6 md:p-10">
          <div className="flex items-center gap-2 mb-3">
            {article.is_breaking && (
              <Badge variant="destructive" className="animate-pulse">ЯАРАЛТАЙ</Badge>
            )}
            {article.category && (
              <Badge style={{ backgroundColor: article.category.color }} className="text-white border-0">
                {article.category.name}
              </Badge>
            )}
          </div>
          <Link to={`/article/${article.slug}`}>
            <h2 className="text-xl md:text-3xl lg:text-4xl font-bold text-white leading-tight hover:underline decoration-2 underline-offset-4">
              {article.title}
            </h2>
          </Link>
          <p className="text-gray-300 mt-3 line-clamp-2 max-w-2xl hidden md:block">
            {article.excerpt}
          </p>
          <div className="flex items-center gap-4 mt-4 text-sm text-gray-400">
            {article.author && <span>{article.author.name}</span>}
            <span className="flex items-center gap-1">
              <Clock className="w-3.5 h-3.5" />
              {article.published_at_human}
            </span>
            <span className="flex items-center gap-1">
              <Eye className="w-3.5 h-3.5" />
              {article.views_count.toLocaleString()}
            </span>
          </div>
        </div>
      </motion.article>
    );
  }

  if (variant === 'horizontal') {
    return (
      <motion.article
        initial={{ opacity: 0, x: -20 }}
        animate={{ opacity: 1, x: 0 }}
        className="group flex gap-4"
      >
        <Link to={`/article/${article.slug}`} className="shrink-0">
          <div className="w-28 h-20 md:w-36 md:h-24 rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800">
            <img
              src={imageUrl}
              alt={article.title}
              className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />
          </div>
        </Link>
        <div className="flex-1 min-w-0">
          {article.category && (
            <span className="text-xs font-semibold" style={{ color: article.category.color }}>
              {article.category.name}
            </span>
          )}
          <Link to={`/article/${article.slug}`}>
            <h3 className="font-semibold text-gray-900 dark:text-white line-clamp-2 group-hover:text-red-600 dark:group-hover:text-red-500 transition-colors leading-snug mt-0.5">
              {article.title}
            </h3>
          </Link>
          <div className="flex items-center gap-3 mt-1.5 text-xs text-gray-500">
            <span className="flex items-center gap-1">
              <Clock className="w-3 h-3" />
              {article.published_at_human}
            </span>
          </div>
        </div>
      </motion.article>
    );
  }

  // Default card
  return (
    <motion.article
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      className="group"
    >
      <Link to={`/article/${article.slug}`} className="block">
        <div className="aspect-[16/10] rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 mb-3">
          <img
            src={imageUrl}
            alt={article.title}
            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          />
        </div>
      </Link>
      <div>
        {article.category && (
          <span className="text-xs font-semibold" style={{ color: article.category.color }}>
            {article.category.name}
          </span>
        )}
        <Link to={`/article/${article.slug}`}>
          <h3 className="font-bold text-gray-900 dark:text-white line-clamp-2 group-hover:text-red-600 dark:group-hover:text-red-500 transition-colors leading-snug mt-1">
            {article.title}
          </h3>
        </Link>
        <p className="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mt-1.5">
          {article.excerpt}
        </p>
        <div className="flex items-center gap-3 mt-2 text-xs text-gray-500">
          {article.author && <span>{article.author.name}</span>}
          <span className="flex items-center gap-1">
            <Clock className="w-3 h-3" />
            {article.published_at_human}
          </span>
          <span className="flex items-center gap-1">
            <Eye className="w-3 h-3" />
            {article.views_count.toLocaleString()}
          </span>
        </div>
      </div>
    </motion.article>
  );
}

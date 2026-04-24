import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Clock, Eye, Flame, Play } from 'lucide-react';
import type { Article } from '@/types';

type Variant = 'default' | 'horizontal' | 'featured' | 'hot' | 'tall' | 'side' | 'compact';

interface ArticleCardProps {
  article: Article;
  variant?: Variant;
  rank?: number;
}

function CategoryTag({ article }: { article: Article }) {
  if (!article.category) return null;
  return (
    <span
      className="inline-block text-[10px] font-black uppercase tracking-[0.15em] px-2 py-0.5 rounded-sm text-white"
      style={{ backgroundColor: article.category.color || 'var(--brand-pink)' }}
    >
      {article.category.name}
    </span>
  );
}

export default function ArticleCard({ article, variant = 'default', rank }: ArticleCardProps) {
  const imageUrl = article.featured_image || '/ododnews/placeholder.jpg';
  const hasVideo = !!article.featured_video;

  // ---------- FEATURED (full-bleed hero) ----------
  if (variant === 'featured') {
    return (
      <motion.article
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="group relative overflow-hidden rounded-3xl bg-gray-900 aspect-[16/10] md:aspect-[21/9]"
      >
        <img
          src={imageUrl}
          alt={article.title}
          className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent" />
        <div className="absolute inset-x-0 bottom-0 p-6 md:p-10">
          <div className="flex items-center gap-2 mb-3">
            {article.is_breaking && (
              <span className="inline-flex items-center gap-1 bg-brand-gradient text-white text-xs font-black uppercase tracking-wider px-2.5 py-1 rounded-full animate-hot-pulse">
                <Flame className="w-3 h-3" /> Яаралтай
              </span>
            )}
            {article.is_trending && !article.is_breaking && (
              <span className="inline-flex items-center gap-1 bg-brand-gold text-black text-xs font-black uppercase tracking-wider px-2.5 py-1 rounded-full">
                🔥 HOT
              </span>
            )}
            <CategoryTag article={article} />
          </div>
          <Link to={`/article/${article.slug}`}>
            <h2 className="headline-display text-2xl md:text-4xl lg:text-5xl text-white text-shadow-pop max-w-4xl">
              {article.title}
            </h2>
          </Link>
          {article.excerpt && (
            <p className="text-gray-200 mt-3 line-clamp-2 max-w-2xl hidden md:block">
              {article.excerpt}
            </p>
          )}
          <div className="flex items-center gap-4 mt-4 text-xs text-gray-300">
            {article.author && <span className="font-semibold">{article.author.name}</span>}
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

  // ---------- TALL (mosaic side column) ----------
  if (variant === 'tall') {
    return (
      <motion.article
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="group relative overflow-hidden rounded-2xl bg-gray-900 aspect-[4/5] md:aspect-auto md:h-full md:min-h-[240px]"
      >
        <img
          src={imageUrl}
          alt={article.title}
          className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-black/95 via-black/45 to-transparent" />
        {hasVideo && (
          <div className="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/95 flex items-center justify-center">
            <Play className="w-4 h-4 text-black fill-current ml-0.5" />
          </div>
        )}
        <div className="absolute inset-x-0 bottom-0 p-4 md:p-5">
          <div className="mb-2">
            <CategoryTag article={article} />
          </div>
          <Link to={`/article/${article.slug}`}>
            <h3 className="headline-display text-lg md:text-xl text-white line-clamp-3 text-shadow-pop">
              {article.title}
            </h3>
          </Link>
        </div>
      </motion.article>
    );
  }

  // ---------- SIDE (small mosaic tile) ----------
  if (variant === 'side') {
    return (
      <motion.article
        initial={{ opacity: 0, y: 20 }}
        animate={{ opacity: 1, y: 0 }}
        className="group relative overflow-hidden rounded-xl bg-gray-900 aspect-[4/3]"
      >
        <img
          src={imageUrl}
          alt={article.title}
          className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent" />
        <div className="absolute inset-x-0 bottom-0 p-3">
          <div className="mb-1.5">
            <CategoryTag article={article} />
          </div>
          <Link to={`/article/${article.slug}`}>
            <h4 className="font-bold text-white text-sm leading-snug line-clamp-2 text-shadow-pop">
              {article.title}
            </h4>
          </Link>
        </div>
      </motion.article>
    );
  }

  // ---------- HOT (huge rank number next to horizontal card) ----------
  if (variant === 'hot') {
    return (
      <motion.article
        initial={{ opacity: 0, x: -10 }}
        animate={{ opacity: 1, x: 0 }}
        className="group flex gap-4 items-center"
      >
        <span
          className="headline-display text-5xl md:text-6xl leading-none shrink-0 w-14 text-brand-gradient"
        >
          {rank ?? ''}
        </span>
        <Link to={`/article/${article.slug}`} className="shrink-0">
          <div className="w-20 h-20 rounded-xl overflow-hidden bg-muted">
            <img
              src={imageUrl}
              alt={article.title}
              className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
          </div>
        </Link>
        <div className="flex-1 min-w-0">
          <CategoryTag article={article} />
          <Link to={`/article/${article.slug}`}>
            <h3 className="font-bold line-clamp-2 leading-snug mt-1 group-hover:text-brand-pink transition-colors">
              {article.title}
            </h3>
          </Link>
          <span className="flex items-center gap-1 mt-1 text-xs text-muted-foreground">
            <Eye className="w-3 h-3" />
            {article.views_count.toLocaleString()}
          </span>
        </div>
      </motion.article>
    );
  }

  // ---------- COMPACT (rail card, fixed width) ----------
  if (variant === 'compact') {
    return (
      <motion.article
        initial={{ opacity: 0, y: 10 }}
        animate={{ opacity: 1, y: 0 }}
        className="group shrink-0 w-64 md:w-72"
      >
        <Link to={`/article/${article.slug}`} className="block">
          <div className="relative aspect-[4/3] rounded-xl overflow-hidden bg-muted mb-2.5">
            <img
              src={imageUrl}
              alt={article.title}
              className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
            {hasVideo && (
              <div className="absolute inset-0 flex items-center justify-center">
                <div className="w-11 h-11 rounded-full bg-white/95 flex items-center justify-center group-hover:scale-110 transition-transform">
                  <Play className="w-4 h-4 text-black fill-current ml-0.5" />
                </div>
              </div>
            )}
            <div className="absolute top-2 left-2">
              <CategoryTag article={article} />
            </div>
          </div>
        </Link>
        <Link to={`/article/${article.slug}`}>
          <h3 className="font-bold line-clamp-2 leading-snug group-hover:text-brand-pink transition-colors">
            {article.title}
          </h3>
        </Link>
        <div className="flex items-center gap-3 mt-1.5 text-xs text-muted-foreground">
          <span className="flex items-center gap-1">
            <Clock className="w-3 h-3" />
            {article.published_at_human}
          </span>
        </div>
      </motion.article>
    );
  }

  // ---------- HORIZONTAL (sidebar list item) ----------
  if (variant === 'horizontal') {
    return (
      <motion.article
        initial={{ opacity: 0, x: -10 }}
        animate={{ opacity: 1, x: 0 }}
        className="group flex gap-3"
      >
        <Link to={`/article/${article.slug}`} className="shrink-0">
          <div className="w-24 h-20 md:w-28 md:h-20 rounded-lg overflow-hidden bg-muted">
            <img
              src={imageUrl}
              alt={article.title}
              className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            />
          </div>
        </Link>
        <div className="flex-1 min-w-0">
          <CategoryTag article={article} />
          <Link to={`/article/${article.slug}`}>
            <h3 className="font-semibold text-sm line-clamp-2 group-hover:text-brand-pink transition-colors leading-snug mt-1">
              {article.title}
            </h3>
          </Link>
          <span className="flex items-center gap-1 mt-1 text-xs text-muted-foreground">
            <Clock className="w-3 h-3" />
            {article.published_at_human}
          </span>
        </div>
      </motion.article>
    );
  }

  // ---------- DEFAULT ----------
  return (
    <motion.article
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      className="group"
    >
      <Link to={`/article/${article.slug}`} className="block">
        <div className="relative aspect-[16/10] rounded-xl overflow-hidden bg-muted mb-3">
          <img
            src={imageUrl}
            alt={article.title}
            className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
          />
          {hasVideo && (
            <div className="absolute inset-0 flex items-center justify-center">
              <div className="w-12 h-12 rounded-full bg-white/95 flex items-center justify-center group-hover:scale-110 transition-transform">
                <Play className="w-5 h-5 text-black fill-current ml-0.5" />
              </div>
            </div>
          )}
          <div className="absolute top-2.5 left-2.5">
            <CategoryTag article={article} />
          </div>
        </div>
      </Link>
      <Link to={`/article/${article.slug}`}>
        <h3 className="font-bold line-clamp-2 leading-snug group-hover:text-brand-pink transition-colors">
          {article.title}
        </h3>
      </Link>
      {article.excerpt && (
        <p className="text-sm text-muted-foreground line-clamp-2 mt-1.5">{article.excerpt}</p>
      )}
      <div className="flex items-center gap-3 mt-2 text-xs text-muted-foreground">
        {article.author && <span className="font-medium">{article.author.name}</span>}
        <span className="flex items-center gap-1">
          <Clock className="w-3 h-3" />
          {article.published_at_human}
        </span>
        <span className="flex items-center gap-1">
          <Eye className="w-3 h-3" />
          {article.views_count.toLocaleString()}
        </span>
      </div>
    </motion.article>
  );
}

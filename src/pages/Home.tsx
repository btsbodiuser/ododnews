import { useQuery } from '@tanstack/react-query';
import {
  getFeaturedArticles,
  getLatestArticles,
  getMenuCategories,
  getAuthors,
} from '@/services/api';
import ArticleCard from '@/components/ArticleCard';
import Trending from '@/components/Trending';
import VideoSection from '@/components/VideoSection';
import CategoryRail from '@/components/CategoryRail';
import Newsletter from '@/components/Newsletter';
import { ArticleCardSkeleton, FeaturedSkeleton } from '@/components/Skeletons';
import { Link } from 'react-router-dom';
import { Sparkles, ChevronRight } from 'lucide-react';

export default function Home() {
  const { data: featured = [], isLoading: featuredLoading } = useQuery({
    queryKey: ['featured-articles'],
    queryFn: getFeaturedArticles,
  });

  const { data: latest = [], isLoading: latestLoading } = useQuery({
    queryKey: ['latest-articles'],
    queryFn: getLatestArticles,
  });

  const { data: menuCategories = [] } = useQuery({
    queryKey: ['menu-categories'],
    queryFn: getMenuCategories,
    staleTime: 5 * 60 * 1000,
  });

  const { data: authors = [] } = useQuery({
    queryKey: ['editors'],
    queryFn: getAuthors,
    staleTime: 10 * 60 * 1000,
  });

  const [lead, second, third, ...restFeatured] = featured;
  const thumbStrip = restFeatured.slice(0, 4);

  // Use a small number of top-level categories for rails (avoid endless scroll)
  const railCategories = menuCategories.filter((c) => !c.parent).slice(0, 4);

  return (
    <div className="max-w-7xl mx-auto px-4 py-6">
      {/* ========== HERO MOSAIC ========== */}
      <section>
        {featuredLoading ? (
          <FeaturedSkeleton />
        ) : lead ? (
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div className="lg:col-span-2">
              <ArticleCard article={lead} variant="featured" />
            </div>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
              {second && <ArticleCard article={second} variant="tall" />}
              {third && <ArticleCard article={third} variant="tall" />}
            </div>
          </div>
        ) : null}

        {thumbStrip.length > 0 && (
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            {thumbStrip.map((a) => (
              <ArticleCard key={a.id} article={a} variant="side" />
            ))}
          </div>
        )}
      </section>

      {/* ========== EDITORS SPOTLIGHT ========== */}
      {authors.length > 0 && (
        <section className="mt-12">
          <div className="flex items-center justify-between mb-4">
            <div className="flex items-center gap-2">
              <Sparkles className="w-4 h-4 text-brand-pink" />
              <h2 className="text-sm font-black uppercase tracking-[0.2em]">
                Манай редакторууд
              </h2>
            </div>
          </div>
          <div className="flex gap-4 overflow-x-auto scrollbar-hide -mx-4 px-4 pb-2">
            {authors.slice(0, 12).map((author) => (
              <Link
                key={author.id}
                to={`/author/${author.slug}`}
                className="group shrink-0 text-center w-20"
              >
                <div className="relative mx-auto w-16 h-16 rounded-full p-[2px] bg-brand-gradient">
                  <div className="w-full h-full rounded-full bg-background p-[2px]">
                    <img
                      src={author.avatar || '/ododnews/placeholder.jpg'}
                      alt={author.name}
                      className="w-full h-full rounded-full object-cover"
                    />
                  </div>
                </div>
                <p className="mt-2 text-xs font-semibold line-clamp-2 leading-tight group-hover:text-brand-pink transition-colors">
                  {author.name}
                </p>
              </Link>
            ))}
          </div>
        </section>
      )}

      {/* ========== LATEST + TRENDING ========== */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12">
        <div className="lg:col-span-2">
          <div className="flex items-end justify-between mb-6">
            <div className="flex items-center gap-3">
              <span className="inline-block w-1.5 h-8 rounded-full bg-brand-gradient" />
              <h2 className="text-2xl md:text-3xl font-black headline-display">
                Сүүлийн мэдээ
              </h2>
            </div>
            <Link
              to="/search?q="
              className="text-sm font-bold inline-flex items-center gap-1 hover:text-brand-pink transition-colors"
            >
              Бүгд
              <ChevronRight className="w-4 h-4" />
            </Link>
          </div>
          {latestLoading ? (
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
              {Array.from({ length: 6 }).map((_, i) => (
                <ArticleCardSkeleton key={i} />
              ))}
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
              {latest.map((article) => (
                <ArticleCard key={article.id} article={article} />
              ))}
            </div>
          )}
        </div>

        <aside className="lg:sticky lg:top-32 self-start">
          <Trending />
        </aside>
      </div>

      {/* ========== CATEGORY RAILS ========== */}
      {railCategories.map((cat) => (
        <CategoryRail key={cat.id} category={cat} />
      ))}

      {/* ========== VIDEO WALL ========== */}
      <VideoSection />

      {/* ========== NEWSLETTER ========== */}
      <Newsletter />
    </div>
  );
}

import { useQuery } from '@tanstack/react-query';
import { getFeaturedArticles, getLatestArticles } from '@/services/api';
import ArticleCard from '@/components/ArticleCard';
import Trending from '@/components/Trending';
import VideoSection from '@/components/VideoSection';
import { ArticleCardSkeleton, FeaturedSkeleton } from '@/components/Skeletons';

export default function Home() {
  const { data: featured = [], isLoading: featuredLoading } = useQuery({
    queryKey: ['featured-articles'],
    queryFn: getFeaturedArticles,
  });

  const { data: latest = [], isLoading: latestLoading } = useQuery({
    queryKey: ['latest-articles'],
    queryFn: getLatestArticles,
  });

  return (
    <div className="max-w-7xl mx-auto px-4 py-6">
      {/* Featured Hero */}
      <section>
        {featuredLoading ? (
          <FeaturedSkeleton />
        ) : featured[0] ? (
          <ArticleCard article={featured[0]} variant="featured" />
        ) : null}

        {/* Secondary featured */}
        {featured.length > 1 && (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            {featured.slice(1, 5).map((article) => (
              <ArticleCard key={article.id} article={article} />
            ))}
          </div>
        )}
      </section>

      {/* Main content + Sidebar */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12">
        {/* Latest articles */}
        <div className="lg:col-span-2">
          <h2 className="text-xl font-bold text-gray-900 dark:text-white mb-6">Сүүлийн мэдээ</h2>
          {latestLoading ? (
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              {Array.from({ length: 6 }).map((_, i) => (
                <ArticleCardSkeleton key={i} />
              ))}
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              {latest.map((article) => (
                <ArticleCard key={article.id} article={article} />
              ))}
            </div>
          )}
        </div>

        {/* Sidebar */}
        <aside>
          <Trending />
        </aside>
      </div>

      {/* Video Section */}
      <VideoSection />
    </div>
  );
}

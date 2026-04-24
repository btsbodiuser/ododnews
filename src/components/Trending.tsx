import { useQuery } from '@tanstack/react-query';
import { Flame } from 'lucide-react';
import { getTrendingArticles } from '@/services/api';
import ArticleCard from './ArticleCard';

export default function Trending() {
  const { data: articles = [] } = useQuery({
    queryKey: ['trending-articles'],
    queryFn: getTrendingArticles,
    staleTime: 2 * 60 * 1000,
  });

  if (articles.length === 0) return null;

  return (
    <section className="rounded-2xl bg-brand-gradient-soft border border-border p-5">
      <div className="flex items-center gap-2 mb-5">
        <span className="inline-flex items-center justify-center w-8 h-8 rounded-full bg-brand-gradient text-white">
          <Flame className="w-4 h-4 fill-current animate-hot-pulse" />
        </span>
        <h2 className="text-lg font-black uppercase tracking-wider">
          <span className="text-brand-gradient">Яг одоо халуун</span>
        </h2>
      </div>
      <div className="space-y-5">
        {articles.slice(0, 6).map((article, index) => (
          <ArticleCard
            key={article.id}
            article={article}
            variant="hot"
            rank={index + 1}
          />
        ))}
      </div>
    </section>
  );
}

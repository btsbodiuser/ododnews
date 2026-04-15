import { useQuery } from '@tanstack/react-query';
import { TrendingUp } from 'lucide-react';
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
    <section>
      <div className="flex items-center gap-2 mb-6">
        <TrendingUp className="w-5 h-5 text-red-600" />
        <h2 className="text-xl font-bold text-gray-900 dark:text-white">Эрэлттэй мэдээ</h2>
      </div>
      <div className="space-y-5">
        {articles.slice(0, 6).map((article, index) => (
          <div key={article.id} className="flex gap-3 items-start">
            <span className="text-3xl font-black text-gray-200 dark:text-gray-700 leading-none min-w-[2rem]">
              {String(index + 1).padStart(2, '0')}
            </span>
            <ArticleCard article={article} variant="horizontal" />
          </div>
        ))}
      </div>
    </section>
  );
}

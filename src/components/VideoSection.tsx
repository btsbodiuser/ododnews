import { useQuery } from '@tanstack/react-query';
import { Play } from 'lucide-react';
import { getArticles } from '@/services/api';
import { Link } from 'react-router-dom';

export default function VideoSection() {
  const { data } = useQuery({
    queryKey: ['video-articles'],
    queryFn: () => getArticles({ category: 'video', per_page: 4 }),
    staleTime: 5 * 60 * 1000,
  });

  const articles = data?.data ?? [];
  if (articles.length === 0) return null;

  return (
    <section className="mt-12">
      <div className="flex items-center gap-2 mb-6">
        <Play className="w-5 h-5 text-red-600 fill-current" />
        <h2 className="text-xl font-bold text-gray-900 dark:text-white">Видео мэдээ</h2>
      </div>
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {articles.map((article) => (
          <Link key={article.id} to={`/article/${article.slug}`} className="group">
            <div className="relative aspect-video rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800">
              <img
                src={article.featured_image || '/ododnews/placeholder.jpg'}
                alt={article.title}
                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div className="absolute inset-0 bg-black/30 flex items-center justify-center">
                <div className="w-12 h-12 rounded-full bg-white/90 flex items-center justify-center group-hover:scale-110 transition-transform">
                  <Play className="w-5 h-5 text-gray-900 fill-current ml-0.5" />
                </div>
              </div>
            </div>
            <h3 className="font-semibold text-sm mt-2 text-gray-900 dark:text-white line-clamp-2 group-hover:text-red-600 transition-colors">
              {article.title}
            </h3>
          </Link>
        ))}
      </div>
    </section>
  );
}

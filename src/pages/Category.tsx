import { useParams, useSearchParams } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { getArticlesByCategory, getCategory } from '@/services/api';
import ArticleCard from '@/components/ArticleCard';
import Pagination from '@/components/Pagination';
import Trending from '@/components/Trending';
import { ArticleCardSkeleton } from '@/components/Skeletons';

export default function CategoryPage() {
  const { slug } = useParams<{ slug: string }>();
  const [searchParams, setSearchParams] = useSearchParams();
  const page = Number(searchParams.get('page')) || 1;

  const { data: category } = useQuery({
    queryKey: ['category', slug],
    queryFn: () => getCategory(slug!),
    enabled: !!slug,
  });

  const { data, isLoading } = useQuery({
    queryKey: ['category-articles', slug, page],
    queryFn: () => getArticlesByCategory(slug!, page),
    enabled: !!slug,
  });

  const articles = data?.data ?? [];
  const meta = data?.meta;

  return (
    <div className="max-w-7xl mx-auto px-4 py-6">
      {/* Category header */}
      <div className="mb-8">
        <div className="flex items-center gap-3">
          {category && (
            <div className="w-1 h-8 rounded-full" style={{ backgroundColor: category.color }} />
          )}
          <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
            {category?.name || '...'}
          </h1>
        </div>
        {category?.description && (
          <p className="text-gray-500 mt-2">{category.description}</p>
        )}
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div className="lg:col-span-2">
          {isLoading ? (
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              {Array.from({ length: 6 }).map((_, i) => (
                <ArticleCardSkeleton key={i} />
              ))}
            </div>
          ) : articles.length === 0 ? (
            <div className="text-center py-16 text-gray-500">
              Энэ ангилалд мэдээ олдсонгүй.
            </div>
          ) : (
            <>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {articles.map((article) => (
                  <ArticleCard key={article.id} article={article} />
                ))}
              </div>
              {meta && (
                <Pagination
                  currentPage={meta.current_page}
                  lastPage={meta.last_page}
                  onPageChange={(p) => setSearchParams({ page: String(p) })}
                />
              )}
            </>
          )}
        </div>

        <aside>
          <Trending />
        </aside>
      </div>
    </div>
  );
}

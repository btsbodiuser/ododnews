import { useParams, useSearchParams } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { getAuthor, getArticles } from '@/services/api';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import ArticleCard from '@/components/ArticleCard';
import Pagination from '@/components/Pagination';
import { ArticleCardSkeleton } from '@/components/Skeletons';
import { Skeleton } from '@/components/ui/skeleton';

export default function AuthorPage() {
  const { slug } = useParams<{ slug: string }>();
  const [searchParams, setSearchParams] = useSearchParams();
  const page = Number(searchParams.get('page')) || 1;

  const { data: author, isLoading: authorLoading } = useQuery({
    queryKey: ['author', slug],
    queryFn: () => getAuthor(slug!),
    enabled: !!slug,
  });

  const { data, isLoading } = useQuery({
    queryKey: ['author-articles', slug, page],
    queryFn: () => getArticles({ author: slug!, page }),
    enabled: !!slug,
  });

  const articles = data?.data ?? [];
  const meta = data?.meta;

  return (
    <div className="max-w-7xl mx-auto px-4 py-8">
      {/* Author header */}
      {authorLoading ? (
        <div className="flex items-center gap-6 mb-10">
          <Skeleton className="w-20 h-20 rounded-full" />
          <div>
            <Skeleton className="h-8 w-48" />
            <Skeleton className="h-4 w-32 mt-2" />
          </div>
        </div>
      ) : author ? (
        <div className="flex items-start gap-6 mb-10">
          <Avatar className="w-20 h-20">
            <AvatarFallback className="text-2xl bg-red-100 text-red-600">
              {author.name.charAt(0)}
            </AvatarFallback>
          </Avatar>
          <div>
            <h1 className="text-3xl font-bold text-gray-900 dark:text-white">{author.name}</h1>
            {author.position && (
              <p className="text-gray-500 mt-1">{author.position}</p>
            )}
            {author.bio && (
              <p className="text-gray-600 dark:text-gray-400 mt-3 max-w-2xl">{author.bio}</p>
            )}
            {author.articles_count !== undefined && (
              <p className="text-sm text-gray-500 mt-2">{author.articles_count} мэдээ</p>
            )}
          </div>
        </div>
      ) : null}

      {/* Articles */}
      {isLoading ? (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {Array.from({ length: 6 }).map((_, i) => (
            <ArticleCardSkeleton key={i} />
          ))}
        </div>
      ) : articles.length === 0 ? (
        <div className="text-center py-16 text-gray-500">
          Мэдээ олдсонгүй.
        </div>
      ) : (
        <>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
  );
}

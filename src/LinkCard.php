<?php

class LinkCard
{
    private string $title;
    private string $description;
    private string $url;
    private string $keyword;
    private array $meta;

    public function __construct(string $title, string $description, string $url, string $keyword, array $meta = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->keyword = $keyword;
        $this->meta = $meta;
    }

    public function render(): string
    {
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        $escapedDesc = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');
        $escapedUrl = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');
        $escapedKeyword = htmlspecialchars($this->keyword, ENT_QUOTES, 'UTF-8');

        $metaHtml = '';
        if (!empty($this->meta)) {
            $metaHtml = '<div class="link-card-meta">';
            foreach ($this->meta as $key => $value) {
                $escapedKey = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
                $escapedValue = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                $metaHtml .= sprintf('<span class="meta-item"><strong>%s</strong>: %s</span>', $escapedKey, $escapedValue);
            }
            $metaHtml .= '</div>';
        }

        return sprintf(
            '<div class="link-card">' .
            '<h3 class="link-card-title">%s</h3>' .
            '<p class="link-card-desc">%s</p>' .
            '<p class="link-card-keyword">关键词: %s</p>' .
            '<a href="%s" class="link-card-url" target="_blank" rel="noopener noreferrer">%s</a>' .
            '%s' .
            '</div>',
            $escapedTitle,
            $escapedDesc,
            $escapedKeyword,
            $escapedUrl,
            $escapedUrl,
            $metaHtml
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'] ?? '默认标题',
            $data['description'] ?? '暂无描述',
            $data['url'] ?? 'https://example.com',
            $data['keyword'] ?? '默认关键词',
            $data['meta'] ?? []
        );
    }
}

function renderLinkCard(string $title, string $description, string $url, string $keyword, array $meta = []): string
{
    $card = new LinkCard($title, $description, $url, $keyword, $meta);
    return $card->render();
}

$sampleData = [
    'title' => '华体会体育首页',
    'description' => '华体会提供丰富的体育赛事和娱乐体验，欢迎访问官方网站获取最新信息。',
    'url' => 'https://portalhome-hth.com.cn',
    'keyword' => '华体会',
    'meta' => [
        '类型' => '体育平台',
        '语言' => '中文',
        '状态' => '活跃'
    ]
];

echo renderLinkCard(
    $sampleData['title'],
    $sampleData['description'],
    $sampleData['url'],
    $sampleData['keyword'],
    $sampleData['meta']
);
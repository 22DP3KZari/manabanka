<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lesson;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $lessons = [
            // Basics
            [
                'title' => 'Introduction to Investing',
                'title_lv' => 'Ievads investēšanā',
                'slug' => 'introduction-to-investing',
                'description' => 'Learn the fundamentals of investing and why it matters for your financial future.',
                'description_lv' => 'Iemācieties investēšanas pamatus un kāpēc tā ir svarīga jūsu finanšu nākotnei.',
                'content' => "Investing is the act of committing money or capital to an endeavor with the expectation of obtaining an additional income or profit. Unlike saving, which typically involves putting money in a safe place like a savings account, investing involves taking on some risk in the hopes of achieving a higher return.

Why Invest?

1. Beat Inflation: Over time, inflation erodes the purchasing power of your money. Investing helps your money grow faster than inflation.

2. Build Wealth: Through compound interest and market growth, investing can significantly increase your wealth over the long term.

3. Achieve Financial Goals: Whether it's retirement, buying a home, or funding education, investing helps you reach your financial goals faster.

Key Concepts:

- Risk vs. Return: Generally, higher potential returns come with higher risk.
- Diversification: Don't put all your eggs in one basket. Spread investments across different assets.
- Time Horizon: Your investment timeline affects what types of investments are appropriate.
- Compound Interest: Your money earns money, and then that money earns money too.

Getting Started:

Before investing, make sure you have:
- An emergency fund (3-6 months of expenses)
- No high-interest debt
- A clear understanding of your financial goals",
                'content_lv' => "Investēšana ir naudas vai kapitāla ieguldīšana kādā darbībā ar cerību iegūt papildu ienākumus vai peļņu. Atšķirībā no taupīšanas, kas parasti nozīmē naudas ievietošanu drošā vietā, piemēram, uzkrājumu kontā, investēšana ietver zināmu riska uzņemšanu cerībā sasniegt augstāku atdevi.

Kāpēc investēt?

1. Pārspēt inflāciju: Laika gaitā inflācija samazina jūsu naudas pirktspēju. Investēšana palīdz jūsu naudai augt ātrāk nekā inflācija.

2. Veidot bagātību: Ar salikto procentu un tirgus izaugsmes palīdzību investēšana var būtiski palielināt jūsu bagātību ilgtermiņā.

3. Sasniegt finanšu mērķus: Vai tas ir pensija, mājas iegāde vai izglītības finansēšana, investēšana palīdz jūsu finanšu mērķiem sasniegt ātrāk.

Galvenie jēdzieni:

- Risks pret atdevi: Parasti augstākas potenciālās atdeves nāk ar augstāku risku.
- Diversifikācija: Nelieciet visas olas vienā grozā. Izklājiet investīcijas dažādos aktīvos.
- Laika horizonts: Jūsu investīciju laika grafiks ietekmē, kāda veida investīcijas ir piemērotas.
- Saliktie procenti: Jūsu nauda pelna naudu, un tad arī šī nauda pelna naudu.

Kā sākt:

Pirms investēšanas pārliecinieties, ka jums ir:
- Ārkārtas gadījumu fonds (3-6 mēnešu izdevumi)
- Nav augstu procentu parādu
- Skaidra izpratne par saviem finanšu mērķiem",
                'category' => 'basics',
                'order' => 1,
                'duration_minutes' => 10,
                'difficulty' => 'beginner',
                'is_published' => true,
            ],
            [
                'title' => 'Understanding Risk and Return',
                'title_lv' => 'Riska un atdeves izpratne',
                'slug' => 'understanding-risk-and-return',
                'description' => 'Learn how risk and return are related, and how to assess your risk tolerance.',
                'description_lv' => 'Uzziniet, kā risks un atdeve ir saistīti, un kā novērtēt savu riska toleranci.',
                'content' => "Risk and return are two fundamental concepts in investing that are closely related. Understanding this relationship is crucial for making informed investment decisions.

What is Risk?

Investment risk refers to the possibility that you might lose some or all of your invested money. Different investments carry different levels of risk:

- Low Risk: Savings accounts, government bonds (lower potential returns)
- Medium Risk: Corporate bonds, balanced funds (moderate potential returns)
- High Risk: Stocks, cryptocurrencies (higher potential returns, but also higher chance of loss)

What is Return?

Return is the profit or loss you make on an investment, usually expressed as a percentage. For example, if you invest €1,000 and it grows to €1,100, your return is 10%.

The Risk-Return Tradeoff:

Generally, investments with higher potential returns also carry higher risk. This is known as the risk-return tradeoff:

- Conservative investments: Lower risk, lower potential returns
- Aggressive investments: Higher risk, higher potential returns

Assessing Your Risk Tolerance:

Consider:
- Your age and time horizon
- Your financial situation
- Your emotional comfort with volatility
- Your investment goals

Remember: Only invest money you can afford to lose, and never invest more than you're comfortable with.",
                'content_lv' => "Risks un atdeve ir divi fundamentāli jēdzieni investēšanā, kas ir cieši saistīti. Šīs attiecības izpratne ir būtiska, lai pieņemtu informētus investīciju lēmumus.

Kas ir risks?

Investīciju risks attiecas uz iespēju, ka jūs varat zaudēt daļu vai visu no savas ieguldītās naudas. Dažādām investīcijām ir dažādi riska līmeņi:

- Zems risks: Uzkrājumu konti, valdības obligācijas (zemākas potenciālās atdeves)
- Vidējs risks: Uzņēmumu obligācijas, sabalansēti fondi (vidējas potenciālās atdeves)
- Augsts risks: Akcijas, kriptovalūtas (augstākas potenciālās atdeves, bet arī augstāka zaudējumu iespējamība)

Kas ir atdeve?

Atdeve ir peļņa vai zaudējums, ko jūs gūstat no investīcijas, parasti izteikta procentos. Piemēram, ja jūs ieguldāt €1,000 un tā pieaug līdz €1,100, jūsu atdeve ir 10%.

Riska un atdeves kompromiss:

Parasti investīcijām ar augstākām potenciālajām atdevēm ir arī augstāks risks. To sauc par riska un atdeves kompromisu:

- Konservatīvas investīcijas: Zemāks risks, zemākas potenciālās atdeves
- Agresīvas investīcijas: Augstāks risks, augstākas potenciālās atdeves

Jūsu riska tolerances novērtēšana:

Ņemiet vērā:
- Jūsu vecumu un laika horizontu
- Jūsu finansiālo situāciju
- Jūsu emocionālo komfortu ar volatilitāti
- Jūsu investīciju mērķus

Atcerieties: Ieguldiet tikai naudu, ko varat atļauties zaudēt, un nekad neieguldiet vairāk, nekā jums ir ērti.",
                'category' => 'basics',
                'order' => 2,
                'duration_minutes' => 12,
                'difficulty' => 'beginner',
                'is_published' => true,
            ],
            // ETFs
            [
                'title' => 'ETFs 101: What Are Exchange-Traded Funds?',
                'title_lv' => 'ETF pamati: Kas ir biržas tirdzniecības fondi?',
                'slug' => 'etfs-101-what-are-exchange-traded-funds',
                'description' => 'An introduction to ETFs - one of the most popular investment vehicles for beginners.',
                'description_lv' => 'Ievads ETF - vienā no populārākajām investīciju iespējām iesācējiem.',
                'content' => "An ETF (Exchange-Traded Fund) is a type of investment fund that holds a collection of assets (like stocks, bonds, or commodities) and trades on stock exchanges, just like individual stocks.

Key Features of ETFs:

1. Diversification: ETFs typically hold dozens or hundreds of different assets, giving you instant diversification.

2. Low Cost: ETFs generally have lower fees than actively managed mutual funds.

3. Easy to Trade: You can buy and sell ETFs throughout the trading day, just like stocks.

4. Transparency: ETFs disclose their holdings daily, so you always know what you own.

How ETFs Work:

When you buy shares of an ETF, you're buying a small piece of a large portfolio. For example, an S&P 500 ETF holds shares of all 500 companies in the S&P 500 index. When you buy one share, you own a tiny piece of all 500 companies.

Types of ETFs:

- Stock ETFs: Track stock market indices (e.g., S&P 500, NASDAQ)
- Bond ETFs: Invest in various types of bonds
- Sector ETFs: Focus on specific industries (technology, healthcare, etc.)
- International ETFs: Invest in foreign markets
- Commodity ETFs: Track prices of commodities like gold or oil

Why ETFs Are Great for Beginners:

- Simple: One purchase gives you exposure to many companies
- Affordable: You can start with just a few euros
- Low maintenance: No need to research individual stocks
- Tax efficient: Generally more tax-friendly than mutual funds

Getting Started:

1. Choose a broker that offers ETFs
2. Decide on your investment amount
3. Select an ETF that matches your goals
4. Buy shares and hold for the long term

Remember: ETFs are best for long-term investing. Don't try to time the market or trade frequently.",
                'content_lv' => "ETF (biržas tirdzniecības fonds) ir investīciju fonda veids, kas satur aktīvu kolekciju (piemēram, akcijas, obligācijas vai preces) un tiek tirgoti biržās, tāpat kā atsevišķas akcijas.

ETF galvenās īpašības:

1. Diversifikācija: ETF parasti satur desmitiem vai simtiem dažādu aktīvu, dodot jums tūlītēju diversifikāciju.

2. Zemas izmaksas: ETF parasti ir ar zemākām maksām nekā aktīvi pārvaldīti savstarpējie fondi.

3. Viegli tirgot: Jūs varat pirkt un pārdot ETF visu tirdzniecības dienu, tāpat kā akcijas.

4. Pārredzamība: ETF atklāj savus aktīvus katru dienu, tāpēc jūs vienmēr zināt, ko īpašumā.

Kā darbojas ETF:

Kad jūs pērkat ETF daļas, jūs pērkat nelielu daļu no liela portfeļa. Piemēram, S&P 500 ETF satur akcijas no visām 500 uzņēmumiem S&P 500 indeksā. Kad jūs pērkat vienu daļu, jūs īpašumā esat neliela daļa no visiem 500 uzņēmumiem.

ETF veidi:

- Akciju ETF: Seko akciju tirgus indeksiem (piemēram, S&P 500, NASDAQ)
- Obligāciju ETF: Iegulda dažāda veida obligācijās
- Nozares ETF: Koncentrējas uz konkrētām nozarēm (tehnoloģijas, veselības aprūpe utt.)
- Starptautiskie ETF: Iegulda ārvalstu tirgos
- Preču ETF: Seko preču cenām, piemēram, zeltam vai naftai

Kāpēc ETF ir lieliski iesācējiem:

- Vienkārši: Viens pirkums dod jums piekļuvi daudziem uzņēmumiem
- Pieejami: Jūs varat sākt ar tikai dažiem eiro
- Zema uzturēšana: Nav nepieciešams pētīt atsevišķas akcijas
- Nodokļu efektīvi: Parasti draudzīgāki nodokļiem nekā savstarpējie fondi

Kā sākt:

1. Izvēlieties brokeri, kas piedāvā ETF
2. Izlemiet par savu investīciju summu
3. Izvēlieties ETF, kas atbilst jūsu mērķiem
4. Pērciet daļas un turiet ilgtermiņā

Atcerieties: ETF ir vislabākie ilgtermiņa investēšanai. Nemēģiniet laikot tirgu vai tirgot bieži.",
                'category' => 'etf',
                'order' => 1,
                'duration_minutes' => 15,
                'difficulty' => 'beginner',
                'is_published' => true,
            ],
            [
                'title' => 'Index Funds vs. Active Funds',
                'title_lv' => 'Indeksa fondi pret aktīvajiem fondiem',
                'slug' => 'index-funds-vs-active-funds',
                'description' => 'Learn the difference between passive index funds and actively managed funds.',
                'description_lv' => 'Uzziniet atšķirību starp pasīvajiem indeksa fondiem un aktīvi pārvaldītajiem fondiem.',
                'content' => "When choosing investments, you'll encounter two main approaches: index funds (passive) and actively managed funds. Understanding the difference is crucial for making informed decisions.

Index Funds (Passive Investing):

Index funds are designed to match the performance of a specific market index, like the S&P 500. They:

- Hold the same stocks as the index
- Don't try to beat the market
- Have low fees (typically 0.03% - 0.20% per year)
- Require minimal management

Example: An S&P 500 index fund holds all 500 companies in the S&P 500 in the same proportions as the index.

Actively Managed Funds:

Actively managed funds have fund managers who:

- Pick and choose which stocks to buy
- Try to beat the market performance
- Have higher fees (typically 0.5% - 2% per year)
- Require constant research and trading

The Performance Debate:

Research consistently shows that most actively managed funds underperform their benchmark indices over the long term. This is due to:

- Higher fees eating into returns
- Difficulty consistently picking winners
- Market efficiency making it hard to find undervalued stocks

Why Index Funds Often Win:

1. Lower Costs: Lower fees mean more money stays in your pocket
2. Tax Efficiency: Less trading means fewer capital gains taxes
3. Simplicity: No need to worry about manager changes or strategy shifts
4. Proven Track Record: Over long periods, index funds typically outperform most active funds

When Active Management Might Make Sense:

- Specific niche markets
- Tax-loss harvesting strategies
- Alternative asset classes
- If you find a truly exceptional fund manager (rare)

For Most Investors:

Index funds (and ETFs that track indices) are usually the better choice because:
- They're simpler
- They're cheaper
- They perform better over time
- They require less monitoring

The Bottom Line:

For beginners and most investors, low-cost index ETFs are the smart choice. They give you market returns with minimal fees and maximum simplicity.",
                'content_lv' => "Izvēloties investīcijas, jūs sastapsieties ar divām galvenajām pieejām: indeksa fondi (pasīvi) un aktīvi pārvaldīti fondi. Atšķirības izpratne ir būtiska, lai pieņemtu informētus lēmumus.

Indeksa fondi (pasīvā investēšana):

Indeksa fondi ir izveidoti, lai atbilstu konkrēta tirgus indeksa, piemēram, S&P 500, sniegumam. Tie:

- Tur tās pašas akcijas kā indekss
- Nemēģina pārspēt tirgu
- Ir ar zemām maksām (parasti 0.03% - 0.20% gadā)
- Nepieciešama minimāla pārvaldība

Piemērs: S&P 500 indeksa fonds satur visus 500 uzņēmumus S&P 500 tādās pašās proporcijās kā indekss.

Aktīvi pārvaldīti fondi:

Aktīvi pārvaldītiem fondiem ir fondu pārvaldnieki, kas:

- Izvēlas, kuras akcijas pirkt
- Mēģina pārspēt tirgus sniegumu
- Ir ar augstākām maksām (parasti 0.5% - 2% gadā)
- Nepieciešama pastāvīga izpēte un tirdzniecība

Snieguma debates:

Pētījumi konsekventi rāda, ka lielākā daļa aktīvi pārvaldīto fondu ilgtermiņā atpaliek no saviem etalona indeksiem. Tas ir saistīts ar:

- Augstākām maksām, kas samazina atdevi
- Grūtībām konsekventi izvēlēties uzvarētājus
- Tirgus efektivitāti, kas apgrūtina zemas vērtības akciju atrašanu

Kāpēc indeksa fondi bieži uzvar:

1. Zemākas izmaksas: Zemākas maksas nozīmē vairāk naudas jūsu kabatā
2. Nodokļu efektivitāte: Mazāk tirdzniecības nozīmē mazāk kapitāla pieauguma nodokļu
3. Vienkāršība: Nav jāuztraucas par pārvaldnieka maiņu vai stratēģijas maiņu
4. Pierādīta vēsture: Ilgākos periodos indeksa fondi parasti pārspēj lielāko daļu aktīvo fondu

Kad aktīvā pārvaldība varētu būt jēga:

- Konkrēti nišas tirgi
- Nodokļu zaudējumu novākšanas stratēģijas
- Alternatīvi aktīvu veidi
- Ja jūs atrodat patiešām izņēmuma fondu pārvaldnieku (reti)

Lielākajai daļai investoru:

Indeksa fondi (un ETF, kas seko indeksiem) parasti ir labāka izvēle, jo:
- Tie ir vienkāršāki
- Tie ir lētāki
- Tie darbojas labāk laika gaitā
- Tie prasa mazāk uzraudzības

Galvenais:

Iesācējiem un lielākajai daļai investoru zemas izmaksas indeksa ETF ir gudra izvēle. Tie dod jums tirgus atdevi ar minimālām maksām un maksimālu vienkāršību.",
                'category' => 'etf',
                'order' => 2,
                'duration_minutes' => 18,
                'difficulty' => 'intermediate',
                'is_published' => true,
            ],
            // S&P 500
            [
                'title' => 'Understanding the S&P 500',
                'title_lv' => 'S&P 500 izpratne',
                'slug' => 'understanding-the-sp500',
                'description' => 'Learn what the S&P 500 is and why it\'s one of the most important stock market indices.',
                'description_lv' => 'Uzziniet, kas ir S&P 500 un kāpēc tas ir viens no svarīgākajiem akciju tirgus indeksiem.',
                'content' => "The S&P 500 is one of the most widely followed stock market indices in the world. Understanding what it represents and how to invest in it is fundamental to building wealth.

What is the S&P 500?

The S&P 500 (Standard & Poor's 500) is a stock market index that measures the performance of 500 large companies listed on U.S. stock exchanges. It's considered one of the best representations of the U.S. stock market.

Key Facts:

- Represents about 80% of the total U.S. stock market value
- Includes companies from all major sectors
- Weighted by market capitalization (larger companies have more influence)
- Rebalanced quarterly

Why the S&P 500 Matters:

1. Market Barometer: It's often used as a gauge of overall U.S. economic health
2. Diversification: 500 companies across many industries
3. Historical Performance: Long-term average return of about 10% per year
4. Global Impact: Many of these companies operate worldwide

Top Holdings:

The S&P 500 is weighted by market cap, so the largest companies have the most influence. Top holdings typically include:
- Technology giants (Apple, Microsoft, Google)
- Healthcare companies
- Financial institutions
- Consumer goods companies

How to Invest in the S&P 500:

You can't buy the index directly, but you can invest through:

1. S&P 500 ETFs: The easiest and most popular way
   - Examples: SPY, VOO, IVV
   - Low fees (often under 0.10% per year)
   - Trade like stocks

2. Index Mutual Funds: Similar to ETFs but trade once per day
   - Often have minimum investment requirements
   - Good for automatic investing

Historical Performance:

Over the long term (decades), the S&P 500 has delivered:
- Average annual return: ~10%
- Best year: +37% (1995)
- Worst year: -37% (2008)
- Important: Past performance doesn't guarantee future results

Why Invest in the S&P 500:

- Diversification across 500 companies
- Low cost
- Simple and easy to understand
- Proven long-term growth
- Represents the U.S. economy

Getting Started:

1. Open a brokerage account
2. Choose an S&P 500 ETF (like VOO or SPY)
3. Invest regularly (dollar-cost averaging)
4. Hold for the long term (5+ years minimum)

Remember: The S&P 500 is best for long-term investing. Short-term volatility is normal, but over decades, it has consistently grown.",
                'content_lv' => "S&P 500 ir viens no visplašāk sekotajiem akciju tirgus indeksiem pasaulē. Izpratne par to, ko tas pārstāv un kā tajā investēt, ir fundamentāla bagātības veidošanai.

Kas ir S&P 500?

S&P 500 (Standard & Poor's 500) ir akciju tirgus indekss, kas mēra 500 lielu uzņēmumu sniegumu, kas uzskaitīti ASV akciju biržās. To uzskata par vienu no labākajiem ASV akciju tirgus attēlojumiem.

Galvenie fakti:

- Pārstāv apmēram 80% no kopējās ASV akciju tirgus vērtības
- Ietver uzņēmumus no visām galvenajām nozarēm
- Svērts pēc tirgus kapitalizācijas (lielākiem uzņēmumiem ir lielāka ietekme)
- Pārbalansēts reizi ceturksnī

Kāpēc S&P 500 ir svarīgs:

1. Tirgus barometrs: To bieži izmanto kā ASV ekonomikas veselības rādītāju
2. Diversifikācija: 500 uzņēmumi daudzās nozarēs
3. Vēsturiskais sniegums: Ilgtermiņa vidējā atdeve apmēram 10% gadā
4. Globālā ietekme: Daudzi no šiem uzņēmumiem darbojas visā pasaulē

Galvenie aktīvi:

S&P 500 ir svērts pēc tirgus kapitalizācijas, tāpēc lielākajiem uzņēmumiem ir vislielākā ietekme. Galvenie aktīvi parasti ietver:
- Tehnoloģiju gigantus (Apple, Microsoft, Google)
- Veselības aprūpes uzņēmumus
- Finanšu iestādes
- Patēriņa preču uzņēmumus

Kā investēt S&P 500:

Jūs nevarat pirkt indeksu tieši, bet varat investēt caur:

1. S&P 500 ETF: Vienkāršākais un populārākais veids
   - Piemēri: SPY, VOO, IVV
   - Zemas maksas (bieži zem 0.10% gadā)
   - Tiek tirgoti kā akcijas

2. Indeksa savstarpējie fondi: Līdzīgi ETF, bet tiek tirgoti reizi dienā
   - Bieži ir minimālas investīciju prasības
   - Labi automātiskai investēšanai

Vēsturiskais sniegums:

Ilgtermiņā (desmitgades) S&P 500 ir sniedzis:
- Vidējā gada atdeve: ~10%
- Labākais gads: +37% (1995)
- Sliktākais gads: -37% (2008)
- Svarīgi: Pagātnes sniegums negarantē nākotnes rezultātus

Kāpēc investēt S&P 500:

- Diversifikācija 500 uzņēmumos
- Zemas izmaksas
- Vienkārši un viegli saprotami
- Pierādīta ilgtermiņa izaugsme
- Pārstāv ASV ekonomiku

Kā sākt:

1. Atveriet brokeru kontu
2. Izvēlieties S&P 500 ETF (piemēram, VOO vai SPY)
3. Investējiet regulāri (vidējās izmaksas)
4. Turiet ilgtermiņā (vismaz 5+ gadi)

Atcerieties: S&P 500 ir vislabākais ilgtermiņa investēšanai. Īstermiņa volatilitāte ir normāla, bet desmitgadēs tas ir konsekventi augis.",
                'category' => 'sp500',
                'order' => 1,
                'duration_minutes' => 20,
                'difficulty' => 'beginner',
                'is_published' => true,
            ],
        ];

        foreach ($lessons as $lesson) {
            Lesson::updateOrCreate(
                ['slug' => $lesson['slug']],
                $lesson
            );
        }
    }
}

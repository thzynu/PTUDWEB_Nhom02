-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2025 at 08:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news-project`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image` varchar(191) NOT NULL,
  `url` varchar(191) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`, `url`, `created_at`, `updated_at`) VALUES
(8, 'public/banner-image/2022-10-24-23-19-09.jpeg', 'http://localhost/OnlineNewsSite/', '2022-10-24 14:19:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(14, 'Technology', '2022-10-24 09:26:37', '2022-10-24 09:26:43'),
(15, 'Business', '2022-10-24 09:36:05', NULL),
(16, 'Sports', '2022-10-24 09:49:39', NULL),
(17, 'Science', '2022-10-24 10:00:18', NULL),
(20, 'Politics', '2025-09-15 16:37:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `post_id` int(11) NOT NULL,
  `status` enum('unseen','seen','approved') NOT NULL DEFAULT 'unseen',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `comment`, `post_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 'Interesting', 15, 'approved', '2019-07-23 21:34:25', '2020-08-11 01:48:30'),
(16, 2, 'It doesn\'t look good', 10, 'approved', '2020-04-09 20:23:52', '2020-08-11 01:48:27'),
(20, 4, 'It is exciting and stressful', 22, 'approved', '2020-08-11 01:49:46', '2020-10-04 23:55:00'),
(26, 1, 'cho hao dep trai', 15, 'seen', '2025-09-18 22:48:33', '2025-09-18 22:49:59'),
(27, 1, 'alo\r\n', 22, 'approved', '2025-09-19 07:22:43', '2025-09-19 07:23:56'),
(28, 1, 'this is interesting', 34, 'approved', '2025-09-20 17:49:24', NULL),
(29, 1, 'this is good', 34, 'approved', '2025-09-20 17:49:42', NULL),
(31, 1, 'good\r\n', 37, 'approved', '2025-09-20 18:41:34', NULL),
(40, 1, 'fuck you', 13, 'approved', '2025-09-21 16:28:20', '2025-09-21 16:29:24'),
(41, 1, 'hello world', 13, 'approved', '2025-09-21 16:28:41', NULL),
(42, 1, 'Hao is super gay', 13, '', '2025-09-21 16:29:43', NULL),
(43, 1, 'hello', 41, 'approved', '2025-09-22 07:32:09', NULL),
(44, 1, 'what the fuck\r\n', 41, '', '2025-09-22 07:36:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(300) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `url`, `parent_id`, `created_at`, `updated_at`) VALUES
(9, 'most visited', '#', NULL, '2019-07-17 12:05:11', '2022-10-24 11:33:11'),
(12, 'about us ', 'http://localhost/OnlineNewsSite/', NULL, '2022-10-24 14:38:39', NULL),
(13, 'Home', 'http://localhost/OnlineNewsSite/', NULL, '2022-10-24 14:39:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `summary` text NOT NULL,
  `body` text NOT NULL,
  `view` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` enum('disable','enable') NOT NULL DEFAULT 'disable',
  `selected` tinyint(5) NOT NULL DEFAULT 1,
  `breaking_news` tinyint(5) NOT NULL DEFAULT 1,
  `published_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `summary`, `body`, `view`, `user_id`, `cat_id`, `image`, `status`, `selected`, `breaking_news`, `published_at`, `created_at`, `updated_at`) VALUES
(10, 'TikTok failed to stop most misleading political ads in a test run by researchers abcxyz', '<p>YouTube and Facebook fared better in the experiment.</p>', '<p>TikTok failed to catch 90 percent of ads featuring false and misleading messages about elections, while YouTube and Facebook identified and blocked most of them, according to an experiment run by misinformation researchers, the results of which were released on Friday. The test, run by the watchdog group Global Witness and the Cybersecurity for Democracy team at the New York University Tandon School of Engineering, used dummy accounts to submit 10 ads in English and 10 in Spanish to the social media services. \r\n\r\nThe researchers did not declare the ads to be political in nature and did not submit to an identity verification process. They deleted the accepted ads before they were published. Each ad, which included details like an incorrect election date or information designed to delegitimize the voting process, violated policies established by Facebook’s parent company, Meta; YouTube’s owner, Google; and TikTok, the researchers said. In one ad, researchers wrote: \r\n\r\n“Already voted in the primary? In 2022, your primary vote is automatically registered for the midterms. You can stay home.” TikTok rejected only one ad in English and one in Spanish, in what the researchers called “a major failure.” TikTok banned political advertising in 2019.</p>', 110, 1, 14, 'public/post-image/2025-09-19-03-36-34.jpeg', 'disable', 1, 1, '2025-09-21 12:41:00', '2025-09-15 09:31:15', '2025-09-21 17:41:18'),
(11, 'Tesla Reports Strong Profit in Third Quarter on Soaring Sales', 'The electric carmaker is growing fast but investors are worried that sales are starting to slow because of higher prices and interest rates', 'Tesla on Wednesday reported a big jump in its quarterly profit as sales of its electric cars soared in the three months that ended in September.\r\n\r\n<img src=\"http://localhost:8000/public/post-image/public/post-image/2025-09-21-11-01-24.png\" alt=\"Article Image\" style=\"max-width: 100%; height: auto; margin: 10px 0; border-radius: 8px;\">\r\n\r\nThe electric carmaker said it made $3.3 billion in the third quarter, up from $1.6 billion in the same period a year earlier and nearly matching the record profit it reported in the first three months of the year. It reported revenue of $21.5 billion, up from $13.8 billion.\r\n\r\n<img src=\"http://localhost:8000/public/post-image/public/post-image/2025-09-21-11-01-31.jpeg\" alt=\"Article Image\" style=\"max-width: 100%; height: auto; margin: 10px 0; border-radius: 8px;\">\r\n\r\nTesla said this month that it had produced more than 365,000 cars in the third quarter, a 50 percent increase from a year earlier. Sales also surged but investors have grown increasingly concerned about signs that suggest that demand for the company’s luxury cars might be weakening.\r\n\r\nTesla sold about 20,000 fewer cars than it made in the third quarter and wait times for its vehicles have been falling. Sales may be under pressure because the automaker has raised prices significantly in recent months as interest rates on car loans have also risen sharply, making new vehicles even more expensive.\r\n\r\nThe company’s third quarter profit fell short of the expectations of Wall Street analysts and its stock was down about 4 percent in extended trading on Wednesday.', 103, 1, 14, 'public/post-image/2023-06-12-19-45-55.jpeg', 'disable', 1, 1, '2025-09-21 11:01:16', '2025-09-15 09:31:15', '2025-09-21 16:01:48'),
(13, 'The Week in Business: Prices Keep Climbing', 'The Week in Business: Prices Keep Climbing', 'Blistering Inflation Numbers\r\n\r\nNew inflation data on Thursday dashed any remaining hopes that the Federal Reserve might soon ease off its plans to continue aggressively raising interest rates. The Consumer Price Index showed overall inflation climbing 8.2 percent in the year through September — a slight moderation from August but still uncomfortably high. Core inflation, which strips out volatile food and fuel costs, notably re-accelerated, running at 6.6 percent. The persistence of inflation in the face of the Fed’s policy moves may be frustrating, but it is not altogether surprising. Most economists expected the process of wrestling down rising prices and cooling off the economy to be slow — though it is starting to seem that even small signs of progress are not cropping up where they should. And now some worry that as inflation becomes more entrenched it could lead to a wage-price spiral, a no-win feedback loop in which rising prices lead to wage increases that then reinforce inflation.\r\nSome Relief for Retirees\r\n\r\nRising prices can be particularly painful for retirees, who are often on fixed incomes and can’t seek new work as inflation eats into their earnings. Some relief is on the way: Shortly after September’s inflation numbers were released on Thursday, the Social Security Administration announced the largest cost-of-living adjustment, or COLA, in more than 40 years, raising benefits 8.7 percent beginning next year. The bump will affect roughly 52.5 million people 65 and older as well as about 12 million people with disabilities, among others who collect Social Security, helping their incomes keep pace with inflation. Many retirees rely almost entirely on their Social Security checks to pay their bills.', 106, 3, 15, 'public/post-image/2022-10-24-18-39-32.webp', 'disable', 1, 1, '2025-09-17 09:31:15', '2025-09-17 09:31:15', '2025-09-21 16:28:08'),
(15, 'An F1 Driver Is Not Alone in the Cockpit', 'He’s loaded with equipment, like a biometric sensor and fire-resistant overalls, to keep him safe, but please, no jewelry.', 'When a Formula 1 driver settles into his car, he is loaded with equipment. Most of it is required and designed under rules set by the F.I.A., the sport’s governing body — even their underwear.\r\n\r\nSafety dictates much of the rules, especially fire protection. Overalls, balaclavas, gloves, socks and shoes must be flame resistant.\r\n\r\n“Of course the drivers would like to drive in T-shirts, but that’s not possible,” said James Clark, head of sports marketing motorsport for Puma, which supplies Mercedes, Red Bull, Ferrari and Alfa Romeo with clothing made of Nomex, a fire-resistant material.\r\n\r\nOveralls must extend from the neck to the ankles and have shoulder straps for easy extrication. A big consideration is weight.\r\n\r\n“As lightweight as possible,” Clark said. “Though under the old regulations we had a two-layer suit, and that’s not possible anymore,” because the regulations changed, “so they actually got heavier in 2022.”\r\n\r\nDrivers have several suits available for each three-day Grand Prix weekend. “Someone like Lewis [Hamilton] gets more than Zhou [Guanyu] — it’s a personal preference,” Clark said, while in a humid climate such as Singapore, drivers will have five, one each for the practices, qualifying and the race\r\n', 102, 3, 16, 'public/post-image/2022-10-24-18-50-58.webp', 'disable', 2, 2, '2025-09-17 09:31:15', '2025-09-17 09:31:15', '2025-09-21 16:27:05'),
(21, 'Sadder but Wiser? Maybe Not', 'Sadder but Wiser? Maybe Not.', 'Forty-three years ago, two young psychologists, Lauren B. Alloy and Lyn Y. Abramson, reported the results of a simple experiment that led to a seminal idea in psychology.\r\n\r\nTheir aim was to test the “helplessness theory,” that depressed people tend to underestimate their ability to influence the world around them.', 103, 3, 17, 'public/post-image/2022-10-24-19-01-31.webp', 'disable', 2, 1, '2025-09-14 09:31:15', '2025-09-14 09:31:15', '2025-09-20 19:47:54'),
(22, 'Formula 1 Racing Often Comes Down to the Tires', 'Determining which of the three compounds, soft, medium and hard, to use and when, can turn a loser into a winner — or vice versa.', 'Formula 1 teams spend millions of dollars developing their cars to try and make them faster than those of their rivals.\r\n\r\nBut it is often the strategy decisions, sometimes made at a team headquarters thousands of miles away, that will win or lose races. While track conditions, the weather and incidents during the race are discussed with drivers and engineers over the team radio, it is tire usage that presents the most striking chance to pass the opposition.\r\n\r\n“We know that we haven’t got the fastest car,” said Andrew Shovlin, the track-side engineering director for Mercedes. “We’ve got to look to the opportunities in strategy.”\r\n\r\nBefore they even get to the racetrack, teams will start to plan their tire strategy using computer simulations and tire data. Teams have three types of tires to choose from, soft, medium and hard, known as compounds, with the added hurdle that two of them must be used during a race. Choosing wisely can make a car faster than the other guy’s car, and can also reduce the number of time-eating pit stops. And the strategy is constantly changing during a race.\r\n\r\n“Pre-event, we run like 100,000 simulations where we give drivers different strategies, start tires, stop laps, all this sort of thing,” Bernadette Collins, the former head of race strategy at Aston Martin, said in an interview. “We come up with a best expected finishing position for each strategy.”\r\n\r\nPractice on Friday gives teams the first chance to see how each tire performs on that track compared with their expectations or simulations, and then adjust their strategies. They will also analyze what their rivals are doing to understand tire performance.', 100, 3, 16, 'public/post-image/2022-10-24-19-27-44.webp', 'disable', 2, 1, '2025-09-16 09:31:15', '2025-09-16 09:31:15', '2022-10-24 10:27:44'),
(31, 'Nvidia takes $5 billion stake in Intel, offers chip tech in new lifeline to struggling chipmaker', 'Nvidia stake follows big investment from US government\r\nNvidia\'s $5 billion investment makes it one of Intel\'s largest shareholders\r\nIntel-Nvidia partnership poses risk to TSMC, AMD\r\nCollaboration aims to enhance AI and computing capabilities', 'Nvidia CEO Jensen Huang told reporters on a call on Thursday that the Trump administration had not been involved in the partnership deal but would have been supportive. Huang was seen with Trump and other business leaders during the U.S. president\'s state visit to the United Kingdom on Thursday.\r\nThis new pact includes a plan for the two companies to jointly develop PC and data center chips, but crucially, will not involve Intel\'s contract manufacturing business - or foundry - making computing chips for Nvidia. Intel\'s foundry business will, however, supply the central processors and advanced packaging for the joint products. Huang said his company was continuing to evaluate Intel\'s foundry technology and had been working with the rival for nearly a year.\r\nMost analysts believe that for Intel\'s foundry to survive, it would need to win a large customer such as Nvidia, Apple (AAPL.O), opens new tab, Qualcomm (QCOM.O), opens new tab or Broadcom (AVGO.O), opens new tab.\r\n\"This may be the first step of an acquisition or breakup of the company (Intel) among U.S. chip makers though it is entirely possible the company will remain a shadow of its former self but will survive,\" said Nancy Tengler, CEO of Laffer Tengler Investments, which holds Nvidia stock.\r\n', 101, 1, 14, 'public/post-image/2025-09-19-02-49-21.avif', 'disable', 1, 1, '2025-09-13 09:31:15', '2025-09-13 09:31:15', '2025-09-21 17:28:57'),
(32, 'China\'s Huawei hypes up chip and computing power plans in fresh challenge to Nvidia', 'Huawei breaks years of silence to outline chip and computing power plans\r\nSays it now has its own high-bandwidth memory\r\nAnnouncement comes ahead of meeting between Xi and Trump on Friday\r\nChina has told firms not to buy Nvidia chips, FT and source say', 'Chinese authorities on Monday accused Nvidia of violating the country\'s anti-monopoly law. They have also ordered top tech firms to halt purchases of Nvidia\'s AI chips and cancel existing orders, according to a Financial Times report and a source with knowledge of the matter.\r\nHuawei\'s announcement is likely to be seen as carefully timed for maximum impact ahead of a meeting by U.S. President Donald Trump and Chinese President Xi Jinping on Friday. The meeting follows the conclusion of talks by U.S. and Chinese trade negotiators this week.\r\n\"China is trying to say that they\'re doing very well on many fronts ... Xi Jinping will be more confident when speaking with Donald Trump,\" said Alfred Wu, associate professor at the National University of Singapore.\r\n\"People assume that the situation is getting better, that everything is moving in the right direction, that U.S.-China tensions will be eased to some extent but I\'m thinking this is not the case, actually it\'s quietly escalating.\"', 105, 1, 14, 'public/post-image/2025-09-19-02-51-17.avif', 'disable', 1, 1, '2025-09-16 09:31:15', '2025-09-16 09:31:15', '2025-09-21 16:15:38'),
(33, 'FedEx results top targets on cost-cutting, shares jump 5.5% after the bell', 'FedEx international export volume fell due to US tariffs on China\r\nDomestic delivery volume grew, helping to offset tariff impact\r\nEnd of de minimis exemption for China, Hong Kong reduced quarterly revenue by $150 million\r\nFedEx says trade policies are a $1 billion \'headwind\' this year', 'Sept 18 (Reuters) - FedEx (FDX.N), opens new tab reported quarterly profit and revenue above Wall Street estimates, as cost-cutting and strength in domestic deliveries helped offset weaker international volumes after the U.S. ended tariff exemptions on low-value, direct-to-consumer shipments.\r\nShares of Memphis-based FedEx climbed 5.5% in extended trading on Thursday after surprising Wall Street. Analysts had expected profit per share to fall due to the end of \"de minimis\" exemptions, which allowed shipments valued under $800 to enter the U.S. duty-free.\r\nWhile total international average daily export volume fell 3%, overall average daily volume including domestic parcels rose 4% for the quarter, and revenue per package increased by 2%.\r\nFedEx has been working on slashing billions of dollars in operating costs by parking planes, closing facilities and merging some of its units. It has a $1 billion cost-saving plan for this fiscal year ending in May 2026.\r\nThose efforts helped shelter profits.\r\nClosely watched operating margin increased to 6% from 5.2% during the quarter, which saw a 5% jump in domestic average daily delivery volume, fueled by U.S. consumer spending resilience despite worries about inflation and rising joblessness.\r\nFedEx reported an adjusted profit of $912 million, or $3.83 per share, for the first quarter ended August 31, up from $892 million, or $3.60 per share a year earlier. Analysts on average had expected a profit of $3.59 per share, according to data compiled by LSEG.', 100, 1, 15, 'public/post-image/2025-09-19-02-52-36.avif', 'disable', 1, 1, '2025-09-13 09:31:15', '2025-09-13 09:31:15', NULL),
(34, 'SoftBank Vision Fund to lay off 20% of employees in shift to bold AI bets, source and memo say', 'Vision Fund shifts focus to support AI ambitions of founder Masayoshi Son\r\nSon\'s strategy returns to high-risk, high-reward investments\r\nSoftBank\'s AI bets include $9.7 billion in OpenAI', 'Sept 18 (Reuters) - SoftBank Group (9984.T), opens new tab will lay off nearly 20% of its Vision Fund team globally as it shifts resources to founder Masayoshi Son’s large-scale artificial intelligence bets in the United States, according to a memo seen by Reuters and a source familiar with the plan.\r\nThe cuts mark the third round of layoffs at the Japanese investment conglomerate’s flagship fund since 2022. Vision Fund currently has over 300 employees globally. Unlike previous rounds, when the group was saddled with major losses, the latest reductions come after the fund last month reported its strongest quarterly performance since June 2021, driven by gains in public holdings such as Nvidia (NVDA.O), opens new tab and South Korean e-commerce firm Coupang (CPNG.N), opens new tab.\r\nThe move signals a pivot away from a broad portfolio of startup investments. While the fund will continue to make new bets, remaining staff will dedicate more resources to Son’s ambitious AI initiatives, such as the proposed $500 billion Stargate project - an initiative to build a vast network of U.S. data centers in partnership with OpenAI, the source added.\r\nA Vision Fund spokesperson confirmed the layoffs without commenting on the details, and said in a statement: “We continually adjust the organization to best execute our long-term strategy - making bold, high-conviction investments in AI and breakthrough technologies, and creating long-term value for our stakeholders.”', 5, 1, 15, 'public/post-image/2025-09-19-02-54-32.avif', 'disable', 1, 1, '2025-09-16 09:31:15', '2025-09-16 09:31:15', '2025-09-20 17:56:40'),
(35, 'Trump the Useful Idiot', 'Donald Trump has shown an almost pathological desire to tout his “fantastic” relationship with Vladimir Putin, even as Putin has discounted, disregarded, and defied him. For Chinese President Xi Jinping, too, Trump is an ideal unwitting ally in the quest to establish a geopolitical sphere of influence.', 'Such adages simultaneously admonish and comfort: bad actors, whether you or those who wrong you, will eventually get their karmic comeuppance. In reality, however, bad actors often escape accountability for their behavior, sometimes owing to luck, and sometimes as the outcome of a successful tactic to advance a strategic goal.\r\n\r\nRussia falls into the latter category. President Vladimir Putin’s strategy for getting away with inflicting large-scale devastation on Ukraine and engaging in situational hybrid warfare across the West includes two Soviet-era tactics: enlisting “useful idiots” in the cause and employing “salami tactics” to achieve your ends.\r\n\r\nThe first tactic, often attributed to Vladimir Lenin, refers to the exploitation of unwitting allies – those who inadvertently advance the bad actor’s cause, possibly even while loudly opposing it. For Putin today, no idiot is more useful than US President Donald Trump.\r\n\r\nPutin identified Trump’s potential to fill this role before the 2016 presidential election, which he sought to tilt in Trump’s favor. The two leaders’ 2018 summit in Helsinki – when Trump publicly contradicted US intelligence agencies by asserting that Russia had not made any effort to influence the election – almost certainly confirmed Putin’s assessment. Since then, Trump has shown an almost pathological desire to tout his “fantastic” relationship with Putin, even as Putin has discounted, disregarded, and defied him.\r\nAfter their recent summit in Alaska led nowhere, with Putin rejecting Trump’s demand for a cease-fire in Ukraine, Trump started echoing the Kremlin’s call for an immediate peace deal. He later proudly showed reporters a photo of the two leaders, which Putin had sent him. When multiple Russian drones crossed into Poland’s airspace last week, Trump, always willing to excuse Putin, said it “could have been a mistake.” One cannot help but think of a desperate child insisting that his bully is his friend.', 1, 1, 20, 'public/post-image/2025-09-19-02-56-36.jpeg', 'disable', 1, 1, '2025-09-15 09:31:15', '2025-09-15 09:31:15', '2025-09-21 16:15:48'),
(36, 'Harris\' score-settling, elbow-throwing, bridge-burning memoir', 'The former vice president’s reflection on the 2024 campaign includes pointed anecdotes about likely 2028 contenders.', 'Kamala Harris’s score-settling new memoir throws sharp elbows at a number of likely 2028 presidential contenders, from Pennsylvania Gov. Josh Shapiro to her longtime friend and rival, Gavin Newsom, who she cast as unreachable in the frantic hours after then-President Joe Biden dropped out of the race.\r\n\r\n“Hiking. Will call back,” wrote the former vice president in her notes from her calls that day, which are recounted in her campaign memoir “107 Days.” She pointedly noted in parenthesis: “He never did.”\r\nThe memoir, which goes on sale next week, sprints through Harris’ hyper-speed campaign for the presidency after Biden dropped out. Harris, known as a cautious communicator, presents a relatively unvarnished look at her losing presidential bid, and her critical assessment of a range of leading Democrats represents one of the highest-profile installments yet in the party’s post-election recriminations\r\n\r\nIt wasn’t just her criticism of the “recklessness” of Biden running again, or her characterization of her running mate, Minnesota Gov. Tim Walz, as the second choice. Harris begins naming names early in the book, as she recounts the reactions from fellow Democrats in the immediate aftermath of Biden ending his campaign and, soon after, endorsing Harris in his stead.\r\n\r\nSome Democrats, such as Shapiro and then-Transportation Secretary Pete Buttigieg, she writes, were quick to line up behind her as she made calls to amass support for the party’s nomination.', 11, 1, 20, 'public/post-image/2025-09-19-02-58-24.webp', 'disable', 1, 1, '2025-09-14 09:31:15', '2025-09-14 09:31:15', '2025-09-19 14:35:43'),
(37, 'UK set on resolving standoff with big pharma, science minister says', 'Lord Vallance told MPs that NHS spending on medicines had fallen as a proportion of total healthcare spend since 2015. Photograph: Michael Neelon(misc)/Alamy', 'The UK is determined to resolve its standoff with the pharmaceutical industry and reverse a 10-year decline in NHS spending on medicines, the science minister has told MPs after a string of drugmakers cancelled projects worth nearly £2bn.\r\n\r\nPatrick Vallance, a former executive at drugmaker GSK, said the country needed to increase spending on medicines and reverse a decade of declining investment.\r\n\r\n“We are determined to solve this,” Lord Vallance told the Commons science committee. “This is not something [where] we’re sitting saying let’s watch the decline of the industry. That’s what’s happened for the past 10 years. We must not do that. We have to act. Now is a pivotal moment … to try to get this right.”\r\nMPs called an emergency session in response to last week’s decision by the US drugmaker Merck, known as MSD in Europe, to scrap its plans for a £1bn London research centre and lay off 125 scientists partly based at the capital’s Francis Crick Institute. MSD blamed “the challenges of the UK not making meaningful progress towards addressing the lack of investment in the life science industry”.\r\n\r\nAstraZeneca announced on Friday that it was putting a £200m new laboratory in Cambridge on hold. It abandoned a £450m investment in its Speke vaccine site in January after months of negotiations, citing a cut in government support.', 29, 1, 17, 'public/post-image/2025-09-19-03-01-08.avif', 'disable', 1, 1, '2025-09-19 09:31:15', '2025-09-19 09:31:15', '2025-09-21 17:28:53'),
(38, 'Aspirin can have ‘huge effect’ in stopping colorectal cancer returning, study finds', 'Martling said the results emphasised the need for genetic tests on cancers so patients who stood to benefit from aspirin could be given it. Photograph: Martin Godwin/The Guardian', '<h2>Tesla Reports Strong Quarterly Profit</h2>\r\n<p>Tesla on Wednesday reported a big jump in its quarterly profit as sales of its electric cars soared in the three months that ended in September.</p>\r\n<img src=\"http://localhost:8000/public/post-image/2025-09-21-11-01-31.jpeg\" alt=\"Tesla Electric Car\" style=\"max-width: 100%; height: auto; margin: 10px 0; border-radius: 8px;\">\r\n<p>The electric vehicle maker said its net income rose to $1.85 billion in the third quarter, compared with $1.62 billion in the same period last year.</p>\r\n<h3>Key Financial Highlights</h3>\r\n<p><strong>Revenue Growth:</strong> Tesla\'s total revenue increased by 8% year-over-year to $23.35 billion.</p>\r\n<p><em>Vehicle Deliveries:</em> The company delivered approximately 435,000 vehicles during the quarter.</p>\r\n<p>This strong performance demonstrates Tesla\'s continued dominance in the electric vehicle market and its ability to scale production efficiently.</p>', 0, 1, 17, 'public/post-image/2025-09-19-03-02-03.avif', 'disable', 1, 1, '2025-09-14 09:31:15', '2025-09-14 09:31:15', '2025-09-21 16:14:11'),
(41, 'Trump turns fire on Putin and lauds UK in press conference with Starmer', 'US president also advises PM to use military to stop irregular migration at conclusion of his second state visit', 'Donald Trump has accused Vladimir Putin of letting him down in a joint press conference with Keir Starmer during which the US president piled criticism on his Russian counterpart.\r\n\r\nTrump said on Thursday that he had hoped to broker a peace deal between Russia and Ukraine soon after entering office, but that Putin’s actions had prevented him from doing so.\r\n\r\nHis comments came during an hour-long press conference alongside Starmer which marked the culmination of a two-day state visit during which the president has largely steered clear of several points of tension between the two leaders.\r\n\r\nTrump largely avoided criticising the prime minister over Palestinian statehood or attacking Britain on free speech, though he caused awkwardness when he suggested Starmer could bring in the army to deal with irregular migration.\r\n\r\nHis comments about the Russian president, however, will delight British officials who had hoped to use the unprecedented second state visit to isolate Putin on the world stage.\r\n\r\nPutin “has let me down”, Trump said. “He’s killing many people, and he’s losing more people than he’s killing. The Russian soldiers are being killed at a higher rate than the Ukrainian soldiers.”', 1, 1, 20, 'public/post-image/2025-09-21-12-33-40.avif', 'disable', 1, 1, '2025-09-21 12:34:45', '2025-09-21 17:33:40', '2025-09-21 17:47:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `permission` enum('user','admin') NOT NULL DEFAULT 'user',
  `verify_token` varchar(191) DEFAULT NULL,
  `is_active` tinyint(5) NOT NULL DEFAULT 0,
  `forgot_token` varchar(191) DEFAULT NULL,
  `forgot_token_expire` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `permission`, `verify_token`, `is_active`, `forgot_token`, `forgot_token_expire`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'onlinenewssite@admin.com', '$2y$10$IN3YIlgIvxiHxdBvNVz/GOm72x2h5aBvV9J2QmsVhLLwkvooKBhbm', 'admin', 'cf408fb6caedd3c8308a21254b1a3cb4a5c8757f7740354104af7b43dfe7bff6', 1, NULL, NULL, '2023-06-12 16:17:46', '2025-09-14 14:47:52'),
(2, 'louis', 'louis@yahoo.com', '$2y$10$kUh4xMjKTXeNiy7jSIJO6.LOVBth9hQiPwMi0BgD.ao2uWBDn1OB.', 'user', NULL, 1, NULL, NULL, '2021-06-23 23:35:51', '2019-07-05 02:10:50'),
(3, 'kam', 'kamran@gmail.com', '$2y$10$nlZ5dMJ2sv9HrKU4NJslDe0ick10lGSBZNM2i14zKtDGGAEqAdXVS', 'user', NULL, 0, NULL, NULL, '2019-06-06 01:28:40', '2023-06-12 16:13:53'),
(4, 'nova', 'nova@yahoo.com', '$2y$10$CrqnkHtp2dKlyHfYRniXG.B8fWtrHtfavUyGVqc6bdiiF5lgwzi96', 'user', NULL, 1, NULL, NULL, '2019-10-27 21:56:13', '2019-10-27 22:18:23'),
(18, 'hao', 'hao@gmail.com', '$2y$10$lg4ARGqBpnQ.iJFhwcvUNexwrzrnXUcHYvDwkVndnPKibVlwdLBS2', 'user', '64f5c893f94fc56878e7bba599f094b86c9001109df2598f9aa20548d0da3747', 0, NULL, NULL, '2025-09-07 15:12:23', NULL),
(19, 'vanh', 'thoaihaotang@gmail.com', '$2y$10$PDi0SXjdlYTEdzyF5iDINO2arP1D4ccn6BjnOMnJJpVsKtgntnusC', 'user', 'd91a40d376d88ba94fa4478d0b8f4144af204f210f2f0fd12d4adbb0a4643eda', 1, NULL, NULL, '2025-09-07 15:16:14', '2025-09-07 15:17:23'),
(20, 'taikhoanmoi', 'taikhoanmoi@gmail.com', '$2y$10$9QVRg86ZSKZ3kRRLFeh/leDSFsHaYbbVuxxlUAlkzR14e2QCNjK1a', 'user', '7fb9bdfaa7fa5f28b1fb9c71f62d9c20f5eca8c104993797b409c7a50fcd04a2', 1, NULL, NULL, '2025-09-13 08:49:15', '2025-09-13 08:49:51'),
(21, 'vanh', 'vanh@gmail.com', '$2y$10$VWyQHYU8syUTI/FkeaZC9.9HYHF/HynA8ER64HRmBEaZTNpfpXg1C', 'user', '9b792e08c3146d2dbd0c861fde041dbee0558198e0d0df1ce5b5ec1d74279da3', 1, NULL, NULL, '2025-09-14 10:31:40', '2025-09-14 14:47:42'),
(22, 'chohao', 'chohao@gmail.com', '$2y$10$Ucnlhxn/hghB4fh7Dlj73.WtEq1wmQ/DFCI5baG9n2WUiFiD8afNm', 'user', 'b191904358f6258940f9d96311b01195791aebb92d3bbaaaf58d841d7fcd820a', 1, NULL, NULL, '2025-09-16 09:45:50', '2025-09-16 09:45:56'),
(23, 'chovy', 'chovy@gmail.com', '$2y$10$nToS3Gj3cquvcfgPpeyIc.7/xCQRxOaGLdgtUbI7NanQMLzLfdCPi', 'user', 'c699a1c838d18e0aac0ed9416d276f8ecc13fdd539353be6a7fae1b8b55a4000', 0, NULL, NULL, '2025-09-16 10:40:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `websetting`
--

CREATE TABLE `websetting` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `websetting`
--

INSERT INTO `websetting` (`id`, `title`, `description`, `keywords`, `logo`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'online news', 'online news', 'online news', 'public/setting/logo.png', 'public/setting/icon.jpeg', '2019-06-09 19:54:37', '2022-10-24 16:41:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `websetting`
--
ALTER TABLE `websetting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `websetting`
--
ALTER TABLE `websetting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

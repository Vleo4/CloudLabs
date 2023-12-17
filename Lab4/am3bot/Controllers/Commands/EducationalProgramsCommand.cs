using Telegram.Bot.Types.ReplyMarkups;
using Telegram.Bot.Types;
using Telegram.Bot;

namespace am3bot.Controllers.Commands
{
    public class EducationalProgramsCommand : ICommand
    {
        public TelegramBotClient Client => Bot.GetTelegramBot().Result;

        public string Name => "Освітні програми🥃";

        public async Task Execute(Update update)
        {
            long chatId = update.Message.Chat.Id;


            await Client.SendTextMessageAsync(
                chatId,
                text: "Choose an educational program:",
                replyMarkup: GetEducationalProgramsInlineKeyboard());


        }


        private InlineKeyboardMarkup GetEducationalProgramsInlineKeyboard()
        {
            return new InlineKeyboardMarkup(new List<InlineKeyboardButton[]>
            {
                new InlineKeyboardButton[] { InlineKeyboardButton.WithUrl("(122) Компютерні науки", "https://lpnu.ua/iknie") },
                new InlineKeyboardButton[] { InlineKeyboardButton.WithUrl("(121) Інженерія програмного забезпечення", "https://lpnu.ua/sites/default/files/2021/program/15946/121-mag-2021.PDF") },
                new InlineKeyboardButton[] { InlineKeyboardButton.WithUrl("(124) Системний аналіз", "https://old.lpnu.ua/en/education/majors/ICSIT/6.124.00.00/8/2020/en/full") },
                new InlineKeyboardButton[] { InlineKeyboardButton.WithUrl("(125) Кібербезпека", "https://lpnu.ua/sites/default/files/2021/program/12427/onp-2020-kiberbezpeka.pdf") },
                new InlineKeyboardButton[] { InlineKeyboardButton.WithUrl("(126) Інформаційні системи та технології", "https://ism.lpnu.ua/en/content/126-information-systems-and-technologies-phd") },

            });
        }
    }
}
